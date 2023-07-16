<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Products\ProductsService;

class ProductsController extends Controller
{
    private ProductsService $productsService;

    public function __construct(ProductsService $pService)
    {
        $this->productsService = $pService;
    }

    public function index()
    {
        $products = $this->productsService->getAllProductsWithCategories();

        return view('admin/products/index', compact('products'));
    }
}
