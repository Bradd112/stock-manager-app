<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => ['required', 'string'],
            'quality_level' => ['required', 'numeric', 'min:1', 'max:5'],
            'website_url' => ['nullable', 'url'],
        ];
    }
}
