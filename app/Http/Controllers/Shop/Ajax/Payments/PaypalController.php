<?php

namespace App\Http\Controllers\Shop\Ajax\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\CreateOrderRequest;
use App\Repositories\RepoOrder;
use App\Services\PaymentMethods\PayPalService;
use Illuminate\Http\JsonResponse;

class PaypalController extends Controller
{
    protected PayPalService $paypalService;
    public function __construct(PayPalService $pService)
    {
        $this->paypalService = $pService;
    }

    public function create(CreateOrderRequest $request, PayPalService $paypal)
    {
        return $paypal->create( $request, new RepoOrder());
    }

    public function capture(string $vendorOrderId) : ?JsonResponse
    {
        return $this->paypalService->capture( $vendorOrderId, new RepoOrder(),);
    }
}
