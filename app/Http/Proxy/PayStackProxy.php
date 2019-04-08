<?php

namespace App\Http\Proxy;


class PayStackProxy extends BaseProxy
{

    public function initializeTransaction($email, $amount, $ref){
        $header = [
            "Authorization: Bearer ".config('app.PAYSTACK_SECRET_KEY'),
            "content-type: application/json",
            "cache-control: no-cache"];
        $payload = [
            'amount'=> $amount,
            'email'=>$email,
            'reference' => $ref
        ];

        $init = $this->sendPost("https://api.paystack.co/transaction/initialize", $header, $payload);

        if($init){
            if($init->status){
                return $init->data;
            }
        }else{
            return false;
        }
    }
}