<?php

namespace App\Http\Controllers\Shop\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class AddProductToCartController extends Controller
{
    public function __invoke( Product $product)
    {
        try
        {
            $cart = Cart::instance('main_cart');

            $cart->add(
                $product,
                1
            );

            return response()->json(['message' => 'Product succesfully added to cart']);
        }
        catch (\Throwable $exception)
        {
            logs()->error($exception);
            return response(status: 422)->json(['message' => $exception->getMessage()]);
        }


    }
}
