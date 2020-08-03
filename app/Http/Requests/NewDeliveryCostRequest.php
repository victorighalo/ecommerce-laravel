<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


class NewDeliveryCostRequest extends FormRequest
{

    public function rules()
    {
        return [
            'state_id' => 'required',
            'city_id' => 'required',
            'cost' => 'required',
        ];

    }

}
