/**
 * Admin panel JS functions
 */
"use strict";
/* global toastr, site_settings */

$(function () {
    const location = window.location.href;
    if(location.indexOf('admin/settings') >= 0){
        Admin.settingsPageInit();
        // eslint-disable-next-line no-undef
        Admin.emailSettingsSwitch(site_settings["emails.driver"]);
        // eslint-disable-next-line no-undef
        Admin.storageSettingsSwitch(site_settings["storage.driver"]);

        Admin.setCustomSettingsTabEvents();
        Admin.paymentsSettingsSwitch('stripe');
        Admin.paymentsSettingsSubTabSwitch('general');


        // Ctrl save on settings
        $(document).bind("keyup keydown", function(e){
            if(e.ctrlKey && e.which == 83){
                $('.save-settings-form').submit();
            }
        });

    }

    // master
    var appContainer = document.querySelector('.app-container'),
        sidebar = appContainer.querySelector('.side-menu'),
        navbar = appContainer.querySelector('nav.navbar.navbar-top'),
        loader = document.getElementById('voyager-loader'),
        hamburgerMenu = document.querySelector('.hamburger'),
        sidebarTransition = sidebar.style.transition,
        navbarTransition = navbar.style.transition,
        containerTransition = appContainer.style.transition;

    sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition =
        appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition =
            navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = 'none';

    if (window.innerWidth > 768 && window.localStorage && window.localStorage['voyager.stickySidebar'] === 'true') {
        appContainer.className += ' expanded no-animation';
        loader.style.left = (sidebar.clientWidth/2)+'px';
        hamburgerMenu.className += ' is-active no-animation';
    }

    navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = navbarTransition;
    sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition = sidebarTransition;
    appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition = containerTransition;

    // login
    if(location.indexOf('admin/login') >= 0){
        var btn = document.querySelector('button[type="submit"]');
        var form = document.forms[0];
        var email = document.querySelector('[name="email"]');
        var password = document.querySelector('[name="password"]');
        btn.addEventListener('click', function(ev){
            if (form.checkValidity()) {
                btn.querySelector('.signingin').className = 'signingin';
                btn.querySelector('.signin').className = 'signin hidden';
            } else {
                ev.preventDefault();
            }
        });
        email.focus();
        document.getElementById('emailGroup').classList.add("focused");

        // Focus events for email and password fields
        email.addEventListener('focusin', function(){
            document.getElementById('emailGroup').classList.add("focused");
        });
        email.addEventListener('focusout', function(){
            document.getElementById('emailGroup').classList.remove("focused");
        });

        password.addEventListener('focusin', function(){
            document.getElementById('passwordGroup').classList.add("focused");
        });
        password.addEventListener('focusout', function(){
            document.getElementById('passwordGroup').classList.remove("focused");
        });
    }

    $('.save-settings-form').on('submit',function(evt){
        // code
        if(Admin.activeSettingsTab == 'payments-processors' || Admin.activeSettingsTab == 'payments-general' || Admin.activeSettingsTab == 'payments-invoices' ) {
            $('.setting_tab').val('Payments');
        }

        if(Admin.activeSettingsTab == 'colors'){
            evt.preventDefault();
            Admin.generateTheme();
        }

        if(!Admin.validateSettingFields()){
            evt.preventDefault();
            // launch toast
        }
    });

    Admin.initThemeColorPickers();

});

var Admin = {

    activeSettingsTab : '',
    themeColors: {
        theme_color_code: '#cb0c9f',
        theme_gradient_from: '#7928CA',
        theme_gradient_to: '#FF0080'
    },

    /**
     * Theme generator function
     */
    generateTheme: function(){
        const data = {
            'skip_rtl' : $('*[name="theme_skip_rtl"]').is(':checked') ? false : true,
            'color_code' : Admin.themeColors.theme_color_code.replace('#',''),
            'gradient_from' : Admin.themeColors.theme_gradient_from.replace('#',''),
            'gradient_to' : Admin.themeColors.theme_gradient_to.replace('#',''),
            'code' : $('*[name="theme_license"]').val(),
        }

        $('#voyager-loader').fadeIn();
        $.ajax({
            type: 'POST',
            data: data,
            url: appUrl + '/admin/theme/generate',
            success: function (result) {
                $('#voyager-loader').fadeOut();
                toastr.success(result.message);
                if(result.data.doBrowserRedirect){
                    window.location="https://themes.qdev.tech/"+result.data.path;
                }
            },
            error: function (result) {
                $('#voyager-loader').fadeOut();
                toastr.error(result.responseJSON.error);
            }
        });
    },

    setCustomSettingsTabEvents: function(){
        $('.settings  .nav a').on('click',function () {
            const tab = $(this).attr('href').replace('#','');
            Admin.activeSettingsTab = tab;
        });
    },

    /**
     * Binds few setting field custom events
     */
    settingsPageInit: function(){
        $('select[name="emails.driver"]').on('change',function () {
            Admin.emailSettingsSwitch($(this).val());
        });
        $('select[name="storage.driver"]').on('change',function () {
            Admin.storageSettingsSwitch($(this).val());
        });
        $('select[name="payments.driver"]').on('change',function () {
            Admin.paymentsSettingsSwitch($(this).val());
        });
        Admin.settingsHide();
    },

    /**
     * Validate setting fields manually, as voyager doesn't apply rules on setting fields
     * @returns {boolean}
     */
    validateSettingFields: function(){
        if(Admin.activeSettingsTab === 'storage' && $('select[name="storage.driver"]').val() === 's3'){
            if(
                $('input[name="storage.aws_access_key').val().length > 0 &&
                $('input[name="storage.aws_secret_key').val().length > 0 &&
                $('input[name="storage.aws_region').val().length > 0 &&
                $('input[name="storage.aws_bucket_name').val().length > 0
            ){
                return true;
            }
            else{
                toastr.error('If using S3 driver, please fill in all the fields.');
                return false;
            }
        }
        if(Admin.activeSettingsTab === 'storage' && $('select[name="storage.driver"]').val() === 'wasabi'){
            if(
                $('input[name="storage.was_access_key').val().length > 0 &&
                $('input[name="storage.was_secret_key').val().length > 0 &&
                $('input[name="storage.was_region').val().length > 0 &&
                $('input[name="storage.was_bucket_name').val().length > 0
            ){
                return true;
            }
            else{
                toastr.error('If using Wasabi driver, please fill in all the fields.');
                return false;
            }
        }
        if(Admin.activeSettingsTab === 'storage' && $('select[name="storage.driver"]').val() === 'do_spaces'){
            if(
                $('input[name="storage.do_access_key').val().length > 0 &&
                $('input[name="storage.do_secret_key').val().length > 0 &&
                $('input[name="storage.do_region').val().length > 0 &&
                $('input[name="storage.do_endpoint').val().length > 0 &&
                $('input[name="storage.do_bucket_name').val().length > 0
            ){
                return true;
            }
            else{
                toastr.error('If using DO Spaces driver, please fill in all the fields.');
                return false;
            }
        }
        return true;
    },

    /**
     * Filters up emails settings based on a dropdown value
     * @param type
     */
    emailSettingsSwitch: function(type){
        Admin.settingsHide('emails');
        $('.setting-row').each(function(key,element) {
            if($(element).attr('class').indexOf(type) >= 0){
                $(element).show();
            }
        });
    },

    paymentsSettingsSwitch: function(type){
        Admin.settingsHide('payments');
        switch (type) {
            case 'stripe':
                $('.setting-row').each(function(key,element) {
                    if($(element).attr('class').indexOf('payments.stripe') >= 0){
                        $(element).show();
                    }
                });
                break;
            case 'paypal':
                $('.setting-row').each(function(key,element) {
                    if($(element).attr('class').indexOf('payments.paypal') >= 0){
                        $(element).show();
                    }
                });
                break;
            case 'coinbase':
                $('.setting-row').each(function(key,element) {
                    if($(element).attr('class').indexOf('payments.coinbase') >= 0){
                        $(element).show();
                    }
                });
                break;
            case 'nowpayments':
                $('.setting-row').each(function(key,element) {
                    if($(element).attr('class').indexOf('payments.nowpayments') >= 0){
                        $(element).show();
                    }
                });
                break;
            case 'ccbill':
                $('.setting-row').each(function(key,element) {
                    if($(element).attr('class').indexOf('payments.ccbill') >= 0){
                        $(element).show();
                    }
                });
                break;
            case 'offline':
                $('.setting-row').each(function(key,element) {
                    if($(element).attr('class').indexOf('payments.allow_manual_payments') >= 0 || $(element).attr('class').indexOf('payments.offline_payments') >= 0){
                        $(element).show();
                    }
                });
                break;
        }
        $('#payments.driver').val(type);

    },

    /**
     * Filters up storage settings based on a dropdown value
     * @param type
     */
    storageSettingsSwitch: function(type){
        Admin.settingsHide('storage');
        if(type === 's3'){
            $('.setting-row').each(function(key,element) {
                if($(element).attr('class').indexOf('aws') >= 0 || $(element).attr('class').indexOf('cdn') >= 0){
                    $(element).show();
                }
            });
        }
        else if(type === 'wasabi'){
            $('.setting-row').each(function(key,element) {
                if($(element).attr('class').indexOf('was') >= 0){
                    $(element).show();
                }
            });
        }
        else if(type === 'do_spaces'){
            $('.setting-row').each(function(key,element) {
                if($(element).attr('class').indexOf('do_') >= 0){
                    $(element).show();
                }
            });
        }
    },

    /**
     * Hides some settings fields by default
     * @param prefix
     */
    settingsHide: function (prefix, hideAll = false) {
        $('.setting-row').each(function(key,element) {
            if($(element).attr('class').indexOf(prefix+'.') >= 0){
                let settingName = $(element).data('settingkey');
                switch (prefix) {
                    case 'emails':
                        if(settingName !== 'emails.driver' && settingName !== 'emails.from_name' && settingName !== 'emails.from_address'){
                            $(element).hide();
                        }
                        break;
                    case 'storage':
                        if(settingName !== 'storage.driver'){
                            $(element).hide();
                        }
                        break;
                    case 'payments':
                        if(hideAll){
                            $(element).hide();
                        }
                        else{
                            if(!['payments.driver','payments.currency_code','payments.currency_symbol','payments.default_subscription_price','payments.min_tip_value','payments.max_tip_value','payments.maximum_subscription_price','payments.minimum_subscription_price'].includes(settingName)){
                                $(element).hide();
                            }
                        }
                        break;
                }
            }
        });
    },

    /**
     * Hides some settings fields by default
     * @param prefix
     */
    paymentsSettingsSubTabSwitch: function (prefix) {
        Admin.settingsHide('payments', true);
        $('.setting-row').each(function(key,element) {

            if($(element).attr('class').indexOf('payments'+'.') >= 0){
                let settingName = $(element).data('settingkey');
                switch (prefix) {
                    case 'general':
                        if(['payments.withdrawal_payment_methods', 'payments.withdrawal_min_amount', 'payments.withdrawal_max_amount', 'payments.deposit_min_amount', 'payments.deposit_max_amount', 'payments.currency_code','payments.currency_symbol','payments.default_subscription_price','payments.min_tip_value','payments.max_tip_value','payments.maximum_subscription_price','payments.minimum_subscription_price'].includes(settingName)){
                            $(element).show();
                        }
                        break;
                    case 'processors':
                        Admin.paymentsSettingsSwitch('stripe');
                        if(['payments.driver'].includes(settingName)){
                            $(element).show();
                        }
                        break;
                    case 'invoices':
                        if(settingName.indexOf('payments.invoices_') >= 0){
                            $(element).show();
                        }
                        break;
                }
            }
        });
    },

    /**
     * Inits the color pickers
     */
    initThemeColorPickers: function(){

        if(site_settings['colors.theme_color_code']){
            Admin.themeColors.theme_color_code = '#' + site_settings['colors.theme_color_code'];
        }

        if(site_settings['colors.theme_gradient_from']){
            Admin.themeColors.theme_gradient_to = '#' + site_settings['colors.theme_gradient_from'];
        }

        if(site_settings['colors.theme_gradient_to']){
            Admin.themeColors.theme_gradient_to = '#' + site_settings['colors.theme_gradient_to'];
        }

        const defaultColors = [
            'rgb(244, 67, 54)',
            'rgb(233, 30, 99)',
            'rgb(156, 39, 176)',
            'rgb(103, 58, 183)',
            'rgb(63, 81, 181)',
            'rgb(33, 150, 243)',
            'rgb(3, 169, 244)',
            'rgb(0, 188, 212)',
            'rgb(0, 150, 136)',
            'rgb(76, 175, 80)',
            'rgb(139, 195, 74)',
            'rgb(205, 220, 57)',
            'rgb(255, 235, 59)',
            'rgb(255, 193, 7)'
        ];

        const theme_color_code_pickr = Pickr.create({
            el: '#theme_color_code',
            theme: 'nano', // or 'monolith', or 'nano'
            default: Admin.themeColors.theme_color_code,
            defaultRepresentation: 'HEX',
            swatches: defaultColors,
            position: 'right-end',
            components: {
                // Main components
                preview: true,
                opacity: false,
                hue: false,
                // Input / output Options
                interaction: {
                    // hex: true,
                    input: true,
                }
            }
        }).on('change', (color, instance) => {
            Admin.themeColors.theme_color_code = color.toHEXA().toString();
            $('.setting-theme_color_code .pickr button').attr('style','background-color:'+color.toHEXA().toString());
        });

        const theme_gradient_from_pickr = Pickr.create({
            el: '#theme_gradient_from',
            theme: 'nano', // or 'monolith', or 'nano'
            default: Admin.themeColors.theme_gradient_from,
            defaultRepresentation: 'HEX',
            swatches: defaultColors,
            position: 'right-end',
            components: {
                // Main components
                preview: true,
                opacity: false,
                hue: false,
                // Input / output Options
                interaction: {
                    input: true,
                }
            }
        }).on('change', (color, instance) => {
            Admin.themeColors.theme_gradient_from = color.toHEXA().toString();
            $('.setting-theme_gradient_from .pickr button').attr('style','background-color:'+color.toHEXA().toString());
        });

        const theme_gradient_to_pickr = Pickr.create({
            el: '#theme_gradient_to',
            theme: 'nano', // or 'monolith', or 'nano'
            default: Admin.themeColors.theme_gradient_to,
            defaultRepresentation: 'HEX',
            swatches: defaultColors,
            position: 'right-end',
            components: {
                // Main components
                preview: true,
                opacity: false,
                hue: false,
                // Input / output Options
                interaction: {
                    input: true,
                }
            }
        }).on('change', (color, instance) => {
            Admin.themeColors.theme_gradient_to = color.toHEXA().toString();
            $('.setting-theme_gradient_to .pickr button').attr('style','background-color:'+color.toHEXA().toString());
        });
    },


};
