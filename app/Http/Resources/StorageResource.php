<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StorageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'address' => $this->address,
            'capacity' => $this->capacity,
            'is_in_abroad' => $this->is_in_abroad ? 'Igen' : 'Nem',
        ];
    }
}
