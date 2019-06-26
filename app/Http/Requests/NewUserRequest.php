<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


class NewUserRequest extends FormRequest
{

    public function rules()
    {
        return [
            'role' => 'required',
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];

    }

}