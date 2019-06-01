<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
        ];
    }
}