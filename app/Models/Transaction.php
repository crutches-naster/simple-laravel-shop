<?php

namespace App\Models;

use App\Enums\PaymentMethods;
use App\Enums\TransactionStatuses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'status'
    ];

    protected $casts = [
        'status' => TransactionStatuses::class,
        'payment_method' => PaymentMethods::class
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
