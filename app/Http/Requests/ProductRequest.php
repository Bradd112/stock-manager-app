<?php

namespace App\Http\Requests;

use App\Rules\StorageHasEnoughCapacityRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => ['required', 'string'],
            'sku' => ['required', 'string', 'unique:products,sku,' . $this->request->get('id')], // TODO
            'price' => ['required', 'numeric', 'min:1'],
            'tax_percentage' => ['required', 'numeric', 'min:1'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'storage_id' => ['nullable', 'exists:storages,id', new StorageHasEnoughCapacityRule()],
        ];
    }
}
