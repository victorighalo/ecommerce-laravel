<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'password' => 'required|min:6|confirmed'
        ];
    }
}