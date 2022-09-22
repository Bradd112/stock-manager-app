<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepository
{
    public function getProductsByStorageId(int $storageId): Collection
    {
        return Product
            ::whereHas('storage', function ($query) use ($storageId) {
                $query->where('id', $storageId);
            })
            ->with('brand')
            ->get();
    }
}
