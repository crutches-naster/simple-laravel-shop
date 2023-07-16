<?php

namespace App\Http\Requests\Categories;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    protected string $className = Category::class;

    public function authorize(): bool
    {
        return auth()
            ->user()
            ->can(
                config('permission.access.categories.publish')
            );
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:50', "unique:{$this->className}"],
            'description' => ['nullable', 'string'],
            'parent_id' => [ 'nullable', "exists:App\Models\Category,id" ],
        ];
    }

}
