<?php
/**
 * Created by PhpStorm.
 * User: itexecutive
 * Date: 19/04/2019
 * Time: 10:26 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class PhotoUploadRequest extends FormRequest
{
    public function rules()
    {
        return [
            'uploaded_file' => 'required|file|mimes:jpeg,jpg,gif,bmp,png|max:400',
        ];
    }
}