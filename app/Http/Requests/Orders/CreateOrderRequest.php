<?php

namespace App\Http\Requests\Orders;

use App\Validation\Rules\ValidPhone;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:35'],
            'surname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:15', new ValidPhone],
            'city' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:100'],
        ];
    }
}
