<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StorageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'address' => $this->address,
            'capacity' => $this->capacity,
            'products_counted' => $this->getProductsCounted(),
            'has_more_capacity' => $this->hasMoreCapacity(),
            'is_in_abroad' => $this->is_in_abroad ? 'Igen' : 'Nem',
            'edit_products_link' => route('product.edit-storage-products', ['storage' => $this->id]),
        ];
    }
}
