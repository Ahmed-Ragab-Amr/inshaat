<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAuthService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('WHATSAUTH_API_KEY');
    }

    public function sendOTP($to, $otp , $message)
    {


        $response = Http::withOptions([
            'verify' => false, // تجاوز التحقق من SSL
        ])->post("https://app.whatsauth.com/api/send", [
            'apikey' => env('WHATSAUTH_API_KEY'),
            'mobile' => $to,
            'msg'    => $message,
        ]);

        return $response->json();
    }
}
