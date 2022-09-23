<?php

namespace App\Rules;

use App\Models\Storage;
use Illuminate\Contracts\Validation\Rule;

class StorageHasEnoughCapacityRule implements Rule
{
    public function passes($attribute, $value)
    {
        $storage = Storage::with('products')->where('id', $value)->first();

        return $storage->hasMoreCapacity();
    }

    public function message()
    {
        return 'There are no more capacity in this storage.';
    }
}
