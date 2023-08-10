<?php

namespace App\Enums;

enum TransactionStatuses: string
{
    case Success = 'success';
    case Canceled = 'canceled';
    case Pending = 'pending';
}
