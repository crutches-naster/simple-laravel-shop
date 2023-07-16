<?php

namespace App\Http\Requests\Categories;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
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
        $categoryId = $this->route('category')->id;

        return [
            'name' => ['required', 'string', 'min:2', 'max:50', Rule::unique(Category::class, 'name')->ignore($categoryId)],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', "exists:App\Models\Category,id"],
        ];
    }

}
