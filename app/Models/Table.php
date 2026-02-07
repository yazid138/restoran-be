<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Table extends Model
{
    protected $fillable = [
        'table_name',
        'status',
        'capacity',
    ];

    protected $casts = [
        'status' => 'string',
        'capacity' => 'integer',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    // Check if table is available
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}
