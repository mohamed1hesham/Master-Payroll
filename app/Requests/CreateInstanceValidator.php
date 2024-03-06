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
        $id = $this->route('id');
        return [
            'base_url' => ['required', 'unique:ci_instances' . ',id'],
            'instance_name' => 'required',
            'username' => 'required',
            'password' => 'required',
        ];
    }
}
