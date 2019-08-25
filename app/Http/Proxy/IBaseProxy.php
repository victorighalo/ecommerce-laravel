<?php
namespace App\Http\Proxy;

interface IBaseProxy
{
    public function sendPost($url, $header, $payload);
    public function sendGet($url,$header);
}
