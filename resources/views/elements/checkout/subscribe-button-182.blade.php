<button class="btn btn-round btn-outline-primary btn-block d-flex justify-content-between mt-2 mb-3 px-5 to-tooltip {{!GenericHelper::isEmailEnforcedAndValidated() ? 'disabled' : ''}}"
        @if(Auth::check())
            @if((Auth::user()->email_verified_at && getSetting('site.enforce_email_validation')) || !getSetting('site.enforce_email_validation'))
                data-toggle="modal"
                data-target="#checkout-center"
                data-type="six-months-subscription"
                data-recipient-id="{{$user->id}}"
                data-amount="{{$user->profile_access_price_6_months ? $user->profile_access_price_6_months * 6 : 0}}"
                data-first-name="{{Auth::user()->first_name}}"
                data-last-name="{{Auth::user()->last_name}}"
                data-billing-address="{{Auth::user()->billing_address}}"
                data-country="{{Auth::user()->country}}"
                data-city="{{Auth::user()->city}}"
                data-state="{{Auth::user()->state}}"
                data-postcode="{{Auth::user()->postcode}}"
                data-available-credit="{{Auth::user()->wallet->total}}"
                data-username="{{$user->username}}"
                data-name="{{$user->name}}"
                data-avatar="{{$user->avatar}}"
            @else
                data-placement="top"
                title="{{__('Please verify your account')}}"
            @endif
        @else
            data-toggle="modal"
            data-target="#login-dialog"
    @endif
>
    <span>{{__('Subscribe')}}</span>
    <span>{{config('app.site.currency_symbol') ?? config('app.site.currency_symbol')}}{{$user->profile_access_price_6_months * 6}}{{config('app.site.currency_symbol') ? '' : ' ' .config('app.site.currency_code')}} {{__('for')}} {{trans_choice('months', 6,['number'=>6])}}</span>
</button>
