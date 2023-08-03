<?php

namespace App\Http\Controllers\Shop;

use App\Models\Product;

class ProductsController
{
    public function show(Product $product)
    {
        return view('products/show', compact('product'));
    }
}
