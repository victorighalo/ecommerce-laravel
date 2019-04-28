<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ];
    }
}