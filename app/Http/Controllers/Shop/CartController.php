<?php

namespace App\Http\Controllers\Shop;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController
{
    public function index()
    {
        return view('cart/index');
    }

    public function add(Request $request, Product $product)
    {
        $cart = Cart::instance('main_cart');

        $cart->add(
            $product,
            $request->get('quantity', 1)
        );

        return redirect()->back();
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'rowId' => ['required', 'string']
        ]);

        Cart::instance('main_cart')->remove($data['rowId']);

        return redirect()->back();
    }

    public function countUpdate(Request $request, Product $product)
    {
        $count = $request->get('product_count', 1);
        $rowId = $request->get('rowId');

        if ( !$rowId || $product->quantity < $count) {
            return redirect()->back();
        }

        Cart::instance('main_cart')->update($rowId, $count);

        return redirect()->back();
    }
}
