<?php

namespace App\Services\Products;

use App\Repositories\RepoProducts;

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


}
