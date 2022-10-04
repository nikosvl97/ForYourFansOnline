<div class="form-group ">
    <div class="card py-3 px-3">
        <div class="custom-control custom-switch custom-switch">
            <input type="checkbox" class="custom-control-input" id="public_profile" {{Auth::user()->public_profile ? 'checked' : ''}}>
            <label class="custom-control-label" for="public_profile">{{__('Is public account')}}</label>
        </div>
        <div class="mt-2">
            <span>{{__('Having your profile set to private means:')}}</span>
            <ul class="mt-1 mb-2">
                <li>{{__('It will be hidden for search engines and unregistered users entirely.')}}</li>
                <li>{{__('It will also be generally hidden from suggestions and user searches on our platform.')}}</li>
            </ul>
        </div>
    </div>

    @if(getSetting('site.allow_users_2fa_switch'))
        <div class="mb-3 card py-3 mt-3">

            <div class="custom-control custom-switch custom-switch">
                <div class="ml-3">
                    <input type="checkbox" class="custom-control-input" id="enable_2fa" {{Auth::user()->enable_2fa ? 'checked' : ''}}>
                    <label class="custom-control-label" for="enable_2fa">{{__('Enable email 2FA')}}</label>
                </div>
                <div class="ml-3 mt-2">
                    <small class="fa-details-label">{{__("If enabled, access from new devices will be restricted until verified.")}}</small>
                </div>
            </div>

            <div class="allowed-devices mx-3 mt-2 {{Auth::user()->enable_2fa ? '' : 'd-none'}}">
                <div class="lists-wrapper mt-2">
                    <div class="px-2 list-item">
                        @if(count($devices))
                            <p class="h6 text-bolder mb-2 text-bold-600">{{__("Allowed devices")}}</p>
                            @foreach($devices as $device)
                                <span class="list-link d-flex flex-column pt-2 pb-2 pl-3 rounded pointer-cursor">
                                    <div class="d-flex flex-row-no-rtl justify-content-between">
                                        <div>
                                            <h6 class="mb-1 d-flex align-items-center">
                                                <span data-toggle="tooltip" data-placement="top" title="{{__($device->device_type)}}">

                                                @switch($device->device_type)
                                                        @case('Desktop')
                                                        @include('elements.icon',['icon'=>'desktop-outline','classes'=>'mr-2'])
                                                        @break
                                                        @case('Mobile')
                                                        @include('elements.icon',['icon'=>'phone-portrait-outline','classes'=>'mr-2'])
                                                        @break
                                                        @case('Tablet')
                                                        @include('elements.icon',['icon'=>'tablet-portrait-outline','classes'=>'mr-2'])
                                                        @break
                                                    @endswitch
                                                </span>

                                                {{$device->browser}} {{__("on")}} {{$device->platform}}</h6>
                                            <small class="text-muted">{{__("Created at")}}: {{$device->created_at}}</small>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center pr-3">
                                            <span class="h-pill h-pill-accent rounded" onclick="PrivacySettings.showDeviceDeleteConfirmation('{{$device->signature}}')">
                                                @include('elements.icon',['icon'=>'close-outline'])
                                            </span>
                                        </div>
                                    </div>
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @endif

</div>

@include('elements.settings.device-delete-dialog')
