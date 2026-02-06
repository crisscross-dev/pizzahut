<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'delivery_address',
        'city',
        'notes',
        'status',
        'subtotal',
        'delivery_fee',
        'tax',
        'total',
        'payment_method',
        'payment_status',
        'estimated_delivery',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'estimated_delivery' => 'datetime',
    ];

    public static function generateOrderNumber(): string
    {
        return 'PH-' . strtoupper(uniqid());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending Confirmation',
            'confirmed' => 'Order Confirmed',
            'preparing' => 'Preparing Your Order',
            'out_for_delivery' => 'Out for Delivery',
            'completed' => 'Completed',
            'delivered' => 'Completed',
            'cancelled' => 'Cancelled',
            default => 'Unknown',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'orange',
            'confirmed' => 'blue',
            'preparing' => 'purple',
            'out_for_delivery' => 'cyan',
            'completed' => 'green',
            'delivered' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    // Accessor aliases for view compatibility
    public function getTotalAmountAttribute(): float
    {
        return (float) $this->total;
    }

    public function getTaxAmountAttribute(): float
    {
        return (float) $this->tax;
    }

    public function getDeliveryCityAttribute(): string
    {
        return $this->city ?? '';
    }

    public function getIsPaidAttribute(): bool
    {
        return $this->payment_status === 'paid';
    }
}
