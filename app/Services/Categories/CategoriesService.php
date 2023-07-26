<?php

namespace App\Services\Categories;

use App\Models\Category;
use App\Repositories\RepoCategories;
use Illuminate\Support\Str;

class CategoriesService
{
    protected RepoCategories $repo;

    public function __construct()
    {
        $this->repo = new RepoCategories();
    }

    public function getAllCategories()
    {
        return $this->repo->getAll();
    }

    public function getPaginatedCategories($count = 5, $order_by_column = 'id')
    {
        return $this->repo->getPaginated(
            count: $count,
            order_by_column: $order_by_column
        );
    }

    public function createNewCategory($validated_data)
    {
        return $this->repo->createNew(
            name: $validated_data['name'],
            slug: Str::of($validated_data['name'])->slug('-'),
            description: $validated_data['description'] ?? null,
            parent_category_id: $validated_data['parent_id'] ?? null
        );
    }

    public function updateCategory($category_id, $validated_data)
    {
        return $this->repo->update(
            id: $category_id,
            name: $validated_data['name'],
            slug: Str::of($validated_data['name'])->slug('-'),
            description: $validated_data['description'] ?? null,
            parent_category_id: $validated_data['parent_id'] ?? null
        );
    }

    public function destroy(Category $category)
    {
        if ($category->children()->exists()) {
            $category->children()->update(['parent_id' => null]);
        }

        return $this->repo->destroy(
            id: $category->id
        );
    }
}
