<?php

namespace App\Repositories\Contracts;

use App\Enums\PaymentMethods;
use App\Enums\TransactionStatuses;
use App\Models\Order;

interface IRepoOrder
{
    public function create(array $data): Order|bool;
    public function setTransaction(string $vendorOrderId, PaymentMethods $method, TransactionStatuses $status);
}
