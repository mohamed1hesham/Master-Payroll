<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstanceValidator extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'base_url' => ['required', 'unique:ci_instances' . ',id'],
            'instance_name' => 'required',
            'username' => 'required',
            'password' => 'required',
        ];
    }
}
