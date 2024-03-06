<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ElementValidator extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'element_name_en' => 'required',
            'element_name_ar' => 'required',
            'order' => 'required',
            'disability' => 'nullable',
        ];
    }
}
