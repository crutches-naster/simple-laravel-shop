<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can(config('permission.access.products.publish'));
    }

    public function rules()
    {
        $productId = $this->route('product')->id;

        return [
            'title' => ['required', 'string', 'min:2', 'max:255', Rule::unique('products', 'title')->ignore($productId)],
            'description' => ['nullable', 'string'],
            'sku' => ['required', 'string', 'min:1', 'max:35', Rule::unique('products', 'sku')->ignore($productId)],
            'base_price' => ['required', 'numeric', 'min:1'],
            'discount' => ['nullable', 'numeric', 'min:0', 'max:99'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'categories.*' => ['required', 'numeric', 'exists:App\Models\Category,id'],
            'thumbnail' => ['nullable', 'image:jpeg,png'],
            'images.*' => ['image:jpeg,png']
        ];
    }
}
