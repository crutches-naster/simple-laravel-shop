<?php

namespace App\Services\Invoices;

use App\Enums\OrderStatuses;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Facades\Invoice as InvoiceBuilder;

class InvoicesService
{
    protected $invoice = null;

    public function generate( Order $order ): Invoice
    {
        if($this->invoice != null)
        {
            return $this->invoice;
        }

        $fullName = "{$order->name} {$order->surname}";
        $orderSerial = $order->vendorOrderId ?? $order->id;
        $fileName = Str::of("{$fullName} {$orderSerial}")->slug('-');

        $customer = new Buyer([
            'name' => $fullName,
            'custom_fields' => [
                'email' => $order->email,
                'phone' => $order->phone,
                'city' => $order->city,
                'address' => $order->address
            ]
        ]);

        $this->invoice = InvoiceBuilder::make()
            ->serialNumberFormat($order->vendorOrderId ?? $order->id)
            ->status($order->status->getName())
            ->buyer($customer)
            ->taxRate(config('cart.tax'))
            ->filename($fileName)
            ->addItems($this->getInvoiceItems($order->products))
            ->logo(public_path('vendor/invoices/sample-logo.png'))
            ->save('public');

        if ( $order->status->getName() === OrderStatuses::InProcess->value) {
            //$this->invoice->payUntil(3);
        }

        return $this->invoice;
    }

    protected function getInvoiceItems(Collection $products): array
    {
        $items = [];

        foreach ($products as $product) {
            $items[] = (new InvoiceItem())
                ->title($product->title)
                ->pricePerUnit($product->pivot->single_price)
                ->quantity($product->pivot->quantity)
                ->units('pcs');
        }

        return $items;
    }
}

