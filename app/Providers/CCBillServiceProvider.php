<?php

namespace App\Providers;

use App\Http\Requests\CreateCCBillTransactionRequest;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class CCBillServiceProvider extends ServiceProvider
{
    const CCBILL_BASE_API_PATH = 'https://api.ccbill.com';
    const OAUTH_TOKEN_PATH = '/ccbill-auth/oauth/token?grant_type=client_credentials';
    const CREATE_TRANSACTION_PATH = '/transactions/payment-tokens/';
    const GET_PAYMENT_TOKEN_PATH = '/payment-tokens/';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    private static function initGuzzle(){
        return new Client();
    }

    public static function generateAccessToken()
    {
        try {
            $ccbillAppCreds = getSetting('payments.ccbill_merchant_application_id') . ':' . getSetting('payments.ccbill_application_secret');
            $response = self::initGuzzle()->request('POST', self::CCBILL_BASE_API_PATH . self::OAUTH_TOKEN_PATH, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic ' . $ccbillAppCreds
                ],
            ]);
            dd($response->getBody());
        } catch (\Exception $exception) {
            dd($exception);
        }

    }

    public static function createTransaction($transaction){
        try{
            $response = self::initGuzzle()->request('POST', self::CCBILL_BASE_API_PATH . self::CREATE_TRANSACTION_PATH . $transaction['ccbill_payment_token_id'], [
                'headers' => [
                    'Authorization' => 'Bearer ' . self::generateAccessToken(),
                    'Accept' => 'application/vnd.mcn.transaction-service.api.v.1+json'
                ]
            ]);
            dd($response->getBody());
        } catch (\Exception $exception){
            dd($exception);
        }
    }

    public static function getPaymentToken($paymentTokenId){
        try{
            $response = self::initGuzzle()->request('POST', self::CCBILL_BASE_API_PATH . self::GET_PAYMENT_TOKEN_PATH . $paymentTokenId, [
               'headers' => [
                   'Authorization' => 'Bearer ' . self::generateAccessToken(),
                   'Accept' => 'application/vnd.mcn.transaction-service.api.v.2+json'
               ]
            ]);
            dd($response->getBody());
        } catch (\Exception $exception) {
            dd($exception);
        }
    }
}
