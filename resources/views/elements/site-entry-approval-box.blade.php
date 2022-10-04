<div class="modal fade" tabindex="-1" role="dialog" id="site-entry-approval-dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="d-flex justify-content-center align-items-center mt-5">
                <img class="brand-logo pb-4" src="{{asset( (Cookie::get('app_theme') == null ? (getSetting('site.default_user_theme') == 'dark' ? getSetting('site.dark_logo') : getSetting('site.light_logo')) : (Cookie::get('app_theme') == 'dark' ? getSetting('site.dark_logo') : getSetting('site.light_logo'))) )}}">
            </div>

            <div class="d-flex justify-content-center align-items-center mt-4 mb-2 px-3 px-md-0">
              <h4 class="text-uppercase text-bolder"><center>{{__("Enter only if you are over 18")}}</center></h4>
</div>
<center>
<div class="modal-body">
<p>
{{__("In my member area you get access to exclusive content (pictures & videos), live chats with me & much more.")}}<br>
{{__("You can choose between a 1 month subscription for €19.99 and a 3 month subscription for €49.99.")}}<br>
{{__("See you! ❤️")}}<br>
</p>

</div>



<div class="modal-body">
<p>{{__("Access only from 18. By using the website I accept the ")}}  <a href="{{route('pages.get',['slug'=>'terms-and-conditions'])}}">{{__("Terms & conditions")}}</a> {{__("and")}} <a href="{{route('pages.get',['slug'=>'privacy'])}}">{{__("Privacy policy")}}</a>.</p>
<p>	{{__("This site only uses technically necessary cookies.")}}</p>
</div>

</center>
            <div class="d-flex">
                <div class="col-6">
                    <button type="submit" class="btn  btn-primary btn-block" onClick="acceptSiteEntry();">
                        {{__('Yes')}}
                    </button>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-link btn-block" onClick="redirect('{{getSetting('compliance.age_verification_cancel_url')}}')">
                        {{__('No')}}
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
