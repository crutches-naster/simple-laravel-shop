<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\IRepoCategory;

class RepoCategories implements IRepoCategory
{
    public function getAll()
    {
        return Category::all();
    }

    public function getById(int $id)
    {
        return Category::query()->find($id);
    }

    public function getPaginated(int $count, string $order_by_column = 'id')
    {
        return Category::query()
            ->orderByDesc($order_by_column)
            ->paginate($count);
    }

    public function createNew(string $name, string $slug, string $description, int $parent_category_id = null )
    {
        return Category::query()
            ->create([
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'parent_id' => $parent_category_id
            ]);
    }

    public function update(int $id, string $name, string $slug, string $description, int $parent_category_id = null )
    {
        return Category::query()
            ->where('id', '=', $id)
            ->update([
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'parent_id' => $parent_category_id
            ]);
    }

    public function destroy($id)
    {
        return Category::query()
            ->where('id', '=', $id)
            ->delete();
    }

    private function detachChildCategories()
    {

    }
}
