<?php

namespace App\Repositories;

use App\Http\Requests\Products\CreateProductRequest;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public function createNew(string $name, )
    {

    }

    public function create($data)
    {
        try {
            DB::beginTransaction();

            $product = Product::query()
                ->create($data['attributes']);

            $product->categories()->sync($data['categories']);

            DB::commit();

            return $product;
        }
        catch (\Throwable $exception)
        {
            DB::rollBack();
            logs()->warning($exception);
            return false;
        }
    }

    public function update($product, $data)
    {
        try {
            DB::beginTransaction();

            $updated = Product::query()
                ->where('id', '=', $product->id)
                ->update(Arr::except($data['attributes'], ['images']));

            $product->categories()->sync($data['categories']);

            DB::commit();

            return $product;
        }
        catch (\Throwable $exception)
        {
            DB::rollBack();
            logs()->warning($exception);
            return false;
        }
    }
}
