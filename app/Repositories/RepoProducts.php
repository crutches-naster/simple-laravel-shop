<?php

namespace App\Repositories;

use App\Models\Product;

class RepoProducts
{
    public function getAll()
    {
        return Product::all();
    }
    public function getPaginated($count = 5, $order_by_column = 'id')
    {
        return Product::query()
            ->orderByDesc($order_by_column)
            ->paginate($count);
    }

    public function getPaginatedWithCategories($count, $order_by_column = 'id')
    {
        return Product::query()
            ->with('categories')
            ->orderByDesc($order_by_column)
            ->paginate($count);
    }
}
