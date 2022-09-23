<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        'title',
        'quality_level',
        'website_url',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
