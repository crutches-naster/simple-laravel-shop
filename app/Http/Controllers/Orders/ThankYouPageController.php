<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;

class ThankYouPageController extends Controller
{

    public function paypal(Order $order)
    {
        $order->loadMissing(['user', 'transaction', 'products']);

        return view('thankyou/summary', compact('order'));
    }
}
