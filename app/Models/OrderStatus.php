<?php

namespace App\Models;

use App\Enums\OrderStatuses;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $casts = [
        'name' => OrderStatuses::class
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeDefault(Builder $query): Builder
    {
        return $this->statusQuery($query, OrderStatuses::InProcess);
    }

    public function scopePaid(Builder $query): Builder
    {
        return $this->statusQuery($query, OrderStatuses::Paid);
    }

    public function scopeCanceled(Builder $query): Builder
    {
        return $this->statusQuery($query, OrderStatuses::Canceled);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $this->statusQuery($query, OrderStatuses::Completed);
    }

    protected function statusQuery(Builder $query, OrderStatuses $enum): Builder
    {
        return $query->where('name', $enum->value);
    }

    public function getName(): string
    {
        return $this->name->value;
    }
}
