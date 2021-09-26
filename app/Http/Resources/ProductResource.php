<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (!isset($this->resource['product_id'])) {
            return [];
        }

        return [
            'product_id' => $this->resource['product_id'] ?? '',
            'product_name' => $this->resource['product_name'] ?? '',
            'product_weight' => $this->resource['product_weight'] ?? '',
            'product_price' => $this->resource['product_price'] ?? '',
            'product_amount' => $this->resource['product_amount'] ?? '',
            'product_type' => $this->resource['product_type'] ?? '',
            'created_at' => $this->resource['created_at'] ?? '',
            'updated_at' => $this->resource['updated_at'] ?? ''
        ];
    }
}
