<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function __invoke()
    {
        $categories = Category::take(6)->get();
        $products = Product::orderByDesc('id')->take(8)->get();

        return view('home', compact('categories', 'products'));
    }
}
