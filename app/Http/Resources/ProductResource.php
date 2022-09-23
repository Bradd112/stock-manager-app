<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'sku' => $this->sku,
            'price' => $this->price,
            'tax_percentage' => $this->tax_percentage,
            'brand' => ($brand = $this->brand) ? new BrandResource($brand) : null,
        ];
    }
}
