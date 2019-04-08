<?php
/**
 * Created by PhpStorm.
 * User: itexecutive
 * Date: 29/03/2019
 * Time: 8:32 AM
 */

namespace App\Http\Requests;



use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'firstname' => 'required|min:2|max:255',
            'lastname'  => 'required|min:2|max:255',
            'phone'  => 'required',
            'email'  => 'required',
            'state'  => 'required',
            'city'  => 'required',
            'notes'  => 'min:20',
            'address' => 'required|min:2|max:555',
        ];
    }

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }
}