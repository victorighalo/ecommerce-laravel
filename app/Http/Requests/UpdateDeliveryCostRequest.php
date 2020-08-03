<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


class UpdateDeliveryCostRequest extends FormRequest
{

    public function rules()
    {
        return [
            'id' => 'required',
            'value' => 'required'
        ];

    }

}
