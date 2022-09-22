<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Storage extends Model
{
    protected $fillable = [
        'title',
        'address',
        'capacity',
        'is_in_abroad',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getProductsCounted(): int
    {
        return $this->products->count();
    }

    public function hasMoreCapacity(): bool
    {
        return $this->getProductsCounted() < $this->capacity;
    }
}
