<?php

namespace App\Repositories;

use App\Enums\PaymentMethods;
use App\Enums\TransactionStatuses;
use App\Events\NewOrderCreatedEvent;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Repositories\Contracts\IRepoOrder;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RepoOrder implements IRepoOrder
{
    public function create(array $data): Order|bool
    {
        $status = OrderStatus::default()->first();
        $data = array_merge(
            $data,
            [
                'status_id' => $status->id
            ]
        );
        $order = auth()->user()->orders()->create($data);

        $this->addProductsToOrder($order);

        NewOrderCreatedEvent::dispatch($order);

        return $order;
    }

    public function setTransaction(string $vendorOrderId, PaymentMethods $method, TransactionStatuses $status): Model|Order|Builder
    {
        $order = Order::where('vendor_order_id', $vendorOrderId)->firstOrFail();
        $order->transaction()->create([
            'payment_method' => $method->value,
            'status' => $status->value,
        ]);

        $status = match($status->value) {
            TransactionStatuses::Success->value => OrderStatus::paid()->first(),
            TransactionStatuses::Canceled->value => OrderStatus::canceled()->first(),
            default => OrderStatus::default()->first()
        };

        $order->update([
            'status_id' => $status->id
        ]);

        return $order;
    }

    protected function addProductsToOrder(Order $order)
    {
        Cart::instance('main_cart')->content()->each(function($item) use ($order) {
            $order->products()->attach($item->model, [
                'quantity' => $item->qty,
                'single_price' => $item->price
            ]);

            $quantity = $item->model->quantity - $item->qty;

            if (!$item->model->update(compact('quantity'))) {
                throw new \Exception("Smth went wrong with quantity update on product [id: {$item->id}]");
            }
        });
    }
}
