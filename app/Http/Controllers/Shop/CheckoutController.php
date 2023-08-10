<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function __invoke()
    {
        return view('checkout/index');
    }
}
