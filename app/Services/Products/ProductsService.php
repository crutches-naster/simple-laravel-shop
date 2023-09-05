<?php

namespace App\Services\Products;

use App\Events\NewProductAddedEvent;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Product;
use App\Repositories\RepoImages;
use App\Repositories\RepoProducts;
use Illuminate\Support\Str;

class ProductsService
{
    private RepoProducts $repoProducts;
    private RepoImages $repoImages;

    public function __construct()
    {
        $this->repoProducts = new RepoProducts();
        $this->repoImages = new RepoImages();
    }

    public function getAllProducts()
    {
        return $this->repoProducts->getAll();
    }

    public function getAllProductsWithCategories($count = 5, $order_by_column = 'id')
    {
        return $this->repoProducts->getPaginatedWithCategories(
            count: $count,
            order_by_column: $order_by_column
        );
    }

    public function createNewProduct($validated_data)
    {
        $prepared_data = $this->formatRequestData($validated_data);

        $product = $this->repoProducts->create($prepared_data);

        if(!empty($prepared_data['attributes']['images'])) {

            $this->repoImages->attach(
                $product, 'images', $prepared_data['attributes']['images'],
                $prepared_data['attributes']['slug']
            );
        }

        NewProductAddedEvent::dispatch($product);

        return $product;
    }

    public function updateProduct(Product $product, $validated_data)
    {
        $prepared_data = $this->formatRequestData($validated_data);

        $product = $this->repoProducts->update($product, $prepared_data);

        if(!empty($prepared_data['attributes']['images'])) {

            $this->repoImages->attach(
                $product, 'images', $prepared_data['attributes']['images'],
                $prepared_data['attributes']['slug']
            );
        }

        return $product;
    }

    public function destroyProduct(Product $product)
    {
        if($product->categories())
        {
            $product->categories()->detach();
        }

        return $product->delete();
    }

    private function formatRequestData($validated_data): array
    {
        return [
            'attributes' => array_merge(
                collect($validated_data)->except(['categories'])->toArray(),
                [
                    'slug' => Str::of($validated_data['title'])->slug('-'),
                ]),
            'categories' => $validated_data['categories'] ?? []
        ];
    }
}
