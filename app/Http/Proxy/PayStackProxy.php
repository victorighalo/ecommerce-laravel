<?php

namespace App\Http\Proxy;

class PayStackProxy extends BaseProxy
{

    public function initializeTransaction($email, $amount, $ref){
        $header = [
            "Authorization: Bearer ".config('app.PAYSTACK_SECRET_KEY'),
//            "content-type: application/json",
//            "cache-control: no-cache"
        ];
        $payload = [
            'amount'=> intval($amount),
            'email'=>$email,
            'reference' => $ref
        ];

        return $this->sendPost("https://api.paystack.co/transaction/initialize", $header, $payload);
    }

    public function verifyTransaction($ref){
        $header = [
            "Authorization: Bearer ".config('app.PAYSTACK_SECRET_KEY'),
            "cache-control: no-cache",
            "accept: application/json"
        ];

        return $this->sendGet("https://api.paystack.co/transaction/verify/". rawurlencode($ref), $header );

    }
}
