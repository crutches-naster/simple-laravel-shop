<?php

namespace App\Services\PaymentMethods;

use App\Enums\PaymentMethods;
use App\Enums\TransactionStatuses;
use App\Events\NewOrderCreatedEvent;
use App\Http\Requests\Orders\CreateOrderRequest;
use App\Repositories\Contracts\IRepoOrder;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal;

class PayPalService
{
    protected PayPal $payPalClient;
    const COMPLETED = "COMPLETED";
    const APPROVED = "APPROVED";
    const CREATED = "CREATED";
    const SAVED = "SAVED";

    public function __construct()
    {
        $this->payPalClient = new PayPal();
        $this->payPalClient->setApiCredentials(config('paypal'));
        $this->payPalClient->setAccessToken($this->payPalClient->getAccessToken());
    }

    public function create( CreateOrderRequest $request, IRepoOrder $repository)
    {
        try
        {
            DB::beginTransaction();
            $total = Cart::instance('main_cart')->total();

            $paypalOrder = $this->createPaymentOrder($total);

            $request = array_merge(
                $request->validated(),
                [
                    'total' => $total,
                    'vendor_order_id' => $paypalOrder['id'],
                ]
            );

            $order = $repository->create($request);

            DB::commit();

            return response()->json($order);
        }
        catch (\Throwable $exception) {
            DB::rollBack();
            return $this->errorHandler($exception);
        }
    }

    public function capture(string $vendorOrderId, IRepoOrder $repository)
    {
        try {
            DB::beginTransaction();

            $result = $this->payPalClient->capturePaymentOrder($vendorOrderId);

            $order = $repository->setTransaction(
                $vendorOrderId,
                PaymentMethods::Paypal,
                $this->convertStatus($result['status'])
            );

            $result['orderId'] = $order->id;

            DB::commit();

            if(!in_array($result['status'], [ static::CREATED, static::SAVED ]))
            {
                Cart::instance('main_cart')->destroy();
            }

            return response()->json($order);
        }
        catch (\Throwable $exception)
        {
            DB::rollBack();
            return $this->errorHandler($exception);
        }
    }

    protected function createPaymentOrder($total): array
    {
        return $this->payPalClient->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => config('paypal.currency'),
                        'value' => $total
                    ]
                ]
            ]
        ]);
    }

    protected function convertStatus(string $status): TransactionStatuses
    {
        return match($status) {
            static::COMPLETED, static::APPROVED => TransactionStatuses::Success,
            static::CREATED, static::SAVED => TransactionStatuses::Pending,
            default => TransactionStatuses::Canceled
        };
    }

    protected function errorHandler(\Exception $exception)
    {
        Log::error($exception->getFile() . ' - ' . $exception->getLine() . ' : ' . $exception->getMessage());

        return response()->json(['error' => $exception->getMessage()], 422);
    }
}
