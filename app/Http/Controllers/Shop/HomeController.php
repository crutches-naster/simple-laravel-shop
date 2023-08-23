<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __invoke()
    {
        $categories = Category::take(6)->get();
        $products = Product::orderByDesc('id')->take(8)->get();

        //Cart::instance('main_cart')->restore(Auth::user()->email);

        return view('home', compact('categories', 'products'));
    }
}
