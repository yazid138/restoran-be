<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use SoftDeletes;

    protected $table = 'foods';

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'status',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'string',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    // Check if food is available
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}
