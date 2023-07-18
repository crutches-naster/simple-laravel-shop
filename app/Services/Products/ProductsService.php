<?php

namespace App\Services\Products;

use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Product;
use App\Repositories\RepoProducts;
use Illuminate\Support\Str;

class ProductsService
{
    private RepoProducts $repo;

    public function __construct()
    {
        $this->repo = new RepoProducts();
    }

    public function getAllProducts()
    {
        return $this->repo->getAll();
    }

    public function getAllProductsWithCategories($count = 5, $order_by_column = 'id')
    {
        return $this->repo->getPaginatedWithCategories(
            count: $count,
            order_by_column: $order_by_column
        );
    }

    public function createNewProduct($validated_data)
    {
        $prepared_data = $this->formatRequestData($validated_data);

        return $this->repo->create($prepared_data);

    }

    public function updateProduct(Product $product, $validated_data)
    {
        $prepared_data = $this->formatRequestData($validated_data);

        return $this->repo->update($product, $prepared_data);
    }

    public function destroyProduct(Product $product)
    {
        return $product->categories()->detach()
            && $product->delete();
    }

    private function formatRequestData($validated_data): array
    {
        return [
            'attributes' => array_merge(
                collect($validated_data)->except(['categories'])->toArray(),
                [
                    'slug' => Str::of($validated_data['title'])->slug('-'),
                    'thumbnail_url' => 'https://via.placeholder.com/640x480.png/004466?text=voluptatum'
                ]),
            'categories' => $validated_data['categories'] ?? []
        ];
    }
}
