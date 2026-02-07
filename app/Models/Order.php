<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'table_id',
        'waiter_id',
        'cashier_id',
        'status',
        'total_price',
        'order_date',
        'closed_at',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'status' => 'string',
        'order_date' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function waiter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    // Add item to order
    public function addItem(Food $food, int $quantity, ?string $notes = null): OrderItem
    {
        $subtotal = $food->price * $quantity;

        $orderItem = $this->orderItems()->create([
            'food_id' => $food->id,
            'quantity' => $quantity,
            'price_at_time' => $food->price,
            'subtotal' => $subtotal,
            'notes' => $notes,
        ]);

        $this->calculateTotal();

        return $orderItem;
    }

    // Calculate and update total price
    public function calculateTotal(): void
    {
        $total = $this->orderItems()->sum('subtotal');
        $this->update(['total_price' => $total]);
    }

    // Close the order
    public function close(User $cashier): void
    {
        $this->update([
            'status' => 'closed',
            'cashier_id' => $cashier->id,
            'closed_at' => now(),
        ]);

        // Update table status back to available
        $this->table()->update(['status' => 'available']);
    }
}
