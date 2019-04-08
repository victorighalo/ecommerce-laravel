<?php
namespace App\Http\Proxy;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Ixudra\Curl\Facades\Curl;
abstract class BaseProxy implements IBaseProxy
{

    public function sendPost($url, $header, $payload){
        try {
            $response = Curl::to($url)
                ->withHeaders($header)
                ->withContentType('application/json')
                ->withData($payload)
                ->asJson()
                ->post();
            if($response){
                return $response;
            }else{
                return false;
            }
        }catch (\Exception $e){
            return false;
        }


    }

    public function sendGet($url){
        $response = Curl::to($url)
            ->get();
    }
}