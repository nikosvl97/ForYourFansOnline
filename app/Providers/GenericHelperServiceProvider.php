<?php

namespace App\Providers;

use App\Model\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Agent;
use Ramsey\Uuid\Uuid;

class GenericHelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Check if user meets all ID verification steps.
     *
     * @return bool
     */
    public static function isUserVerified()
    {
        if (
            (Auth::user()->verification && Auth::user()->verification->status == 'verified') &&
            Auth::user()->birthdate &&
            Auth::user()->email_verified_at
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Creates a default wallet for a user.
     * @param $user
     */
    public static function createUserWallet($user)
    {
        try {
            $userWallet = Wallet::query()->where('user_id', $user->id)->first();
            if ($userWallet == null) {
                // generate unique id for wallet
                do {
                    $id = Uuid::uuid4()->getHex();
                } while (Wallet::query()->where('id', $id)->first() != null);

                Wallet::create([
                    'id' => $id,
                    'user_id' => $user->id,
                    'total' => 0.0,
                    'paypal_balance' => 0.0,
                    'stripe_balance' => 0.0,
                ]);
            }
        } catch (\Exception $exception) {
            Log::error('User wallet creation error: '.$exception->getMessage());
        }
    }

    /**
     * Static function that handles remote storage drivers
     *
     * @param $value
     * @return string
     */
    public static function getStorageAvatarPath($value){
        if($value && $value !== config('voyager.user.default_avatar', '/img/default-avatar.png')){
            if(getSetting('storage.driver') == 's3'){
                return 'https://'.getSetting('storage.aws_bucket_name').'.s3.'.getSetting('storage.aws_region').'.amazonaws.com/'.$value;
            }
            elseif(getSetting('storage.driver') == 'wasabi' || getSetting('storage.driver') == 'do_spaces'){
                return Storage::url($value);
            }
            else{
                return Storage::disk('public')->url($value);
            }
        }else{
            return str_replace('storage/','',asset(config('voyager.user.default_avatar', '/img/default-avatar.png')));
        }
    }

    /**
     * Helper to detect mobile usage
     * @return bool
     */
    public static function isMobileDevice(){
        $agent = new Agent();
        return $agent->isMobile();
    }

    /**
     * Returns true if email enforce is not enabled or if is set to true and user is verified
     * @return bool
     */
    public static function isEmailEnforcedAndValidated(){
            return ((Auth::check() && Auth::user()->email_verified_at) || (Auth::check() && !getSetting('site.enforce_email_validation')));
    }

}
