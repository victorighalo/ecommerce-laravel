<?php

namespace App\Http\Proxy;


class PayStackProxy extends BaseProxy
{

    public function initializeTransaction($email, $amount, $ref){
        $header = [
            "Authorization: Bearer ".config('app.PAYSTACK_SECRET_KE'),
            "content-type: application/json",
            "cache-control: no-cache"];
        $payload = [
            'amount'=> $amount,
            'email'=>$email,
            'reference' => $ref
        ];

        return $this->sendPost("https://api.paystack.co/transaction/initialize", $header, $payload);


    }
}