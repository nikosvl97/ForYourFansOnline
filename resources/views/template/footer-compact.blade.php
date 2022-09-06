<footer class="d-md-block mobile-ver">
    <!-- A grey container -->
    <div class="greycontainer">
        <!-- A black container -->
        <div class="blackcontainer">
            <!-- Container to indent the content -->
            <div class="container">
                <div class="clearfix"></div>
                <br />
                <div class="copyRightInfo d-flex flex-column-reverse flex-md-row d-md-flex justify-content-md-between">
<!--  <p class="">&copy; {{date('Y')}} {{getSetting('site.name')}} </p> -->

                  <a class="copyRightInfo" href="https://mepunkt.de{{getSetting('site.name')}}&utm_medium=click_banner&utm_campaign=footer_logo" target="_blank">
                     <img style="width:10vh;"src="/img/logos/mepunkt-werbeagentur-nuernberg-hell.png">
                  </a>




					<p class="">
					<a class="copyRightInfo" href="{{route('pages.get',['slug'=>'impressum'])}}" target="_blank">
                                   {{__('Imprint')}} | 
                                </a>
					<a class="copyRightInfo" href="{{route('pages.get',['slug'=>'terms-and-conditions'])}}" target="_blank">
                                   {{__('Terms & Conditions')}} | 
                                </a>
					<a class="copyRightInfo" href="{{route('pages.get',['slug'=>'privacy'])}}" target="_blank">
                                   {{__('Privacy Policy')}}
                                </a>
                    <ul class="d-flex flex-row nav m-2 mt-md-0">
                        @if(getSetting('social-media.facebook_url'))
                            <li class="nav-item">
                                <a class="nav-link pe-1" href="{{getSetting('social-media.facebook_url')}}" target="_blank">
                                    @include('elements.icon',['icon'=>'logo-facebook','variant'=>'medium','classes' => 'text-lg opacity-8'])
                                </a>
                            </li>
                        @endif
                        @if(getSetting('social-media.twitter_url'))
                            <li class="nav-item">
                                <a class="nav-link pe-1" href="{{getSetting('social-media.twitter_url')}}" target="_blank">
                                    @include('elements.icon',['icon'=>'logo-twitter','variant'=>'medium','classes' => 'text-lg opacity-8'])
                                </a>
                            </li>
                        @endif
                        @if(getSetting('social-media.instagram_url'))
                            <li class="nav-item">
                                <a class="nav-link pe-1" href="{{getSetting('social-media.instagram_url')}}" target="_blank">
                                    @include('elements.icon',['icon'=>'logo-instagram','variant'=>'medium','classes' => 'text-lg opacity-8'])
                                </a>
                            </li>
                        @endif
                        @if(getSetting('social-media.whatsapp_url'))
                            <li class="nav-item">
                                <a class="nav-link pe-1" href="{{getSetting('social-media.whatsapp_url')}}" target="_blank">
                                    @include('elements.icon',['icon'=>'logo-whatsapp','variant'=>'medium','classes' => 'text-lg opacity-8'])
                                </a>
                            </li>
                        @endif
                        @if(getSetting('social-media.tiktok_url'))
                            <li class="nav-item">
                                <a class="nav-link pe-1" href="{{getSetting('social-media.tiktok_url')}}" target="_blank">
                                    @include('elements.icon',['icon'=>'logo-tiktok','variant'=>'medium','classes' => 'text-lg opacity-8'])
                                </a>
                            </li>
                        @endif
                        @if(getSetting('social-media.youtube_url'))
                            <li class="nav-item">
                                <a class="nav-link pe-1" href="{{getSetting('social-media.youtube_url')}}" target="_blank">
                                    @include('elements.icon',['icon'=>'logo-youtube','variant'=>'medium','classes' => 'text-lg opacity-8'])
                                </a>
                            </li>
                        @endif
                                <a class="copyRightInfo" href="https://grandhosting.gr?utm_source=foryourfans_{{getSetting('site.name')}}&utm_medium=click_banner&utm_campaign=footer_logo" target="_blank">
                                   <img style="width:7vh;"src="/img/logos/grandhosting_logo_poweredby.png">
                                </a>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
