<?php

namespace App\Repositories;

use App\Models\Storage;
use Illuminate\Support\Collection;

class StorageRepository
{
    public function getStorages(): Collection
    {
        return Storage::all();
    }
}
