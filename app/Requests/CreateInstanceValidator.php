<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInstanceValidator extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'base_url' => ['required', 'unique:ci_instances'],
            'instance_name' => 'required',
            'username' => 'required',
            'password' => 'required',
        ];
    }
}
