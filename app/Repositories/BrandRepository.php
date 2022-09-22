<?php

namespace App\Repositories;

use App\Models\Brand;
use Illuminate\Support\Collection;

class BrandRepository
{
    public function getBrands(): Collection
    {
        return Brand::all();
    }
}
