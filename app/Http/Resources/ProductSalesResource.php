<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSalesResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->product,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'total' => $this->total,
            'store_total' => $this->store_total,
        ];
    }
}
