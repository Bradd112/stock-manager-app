<?php

namespace App\Repositories;

use App\Models\Storage;

class StorageRepository
{
    public function getStorages()
    {
        return Storage::all();
    }
}
