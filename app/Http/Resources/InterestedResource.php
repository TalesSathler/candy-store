<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InterestedResource extends JsonResource
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
            'interested_id' => $this->resource['interested_id'] ?? '',
            'product_id' => $this->resource['product_id'] ?? '',
            'interested_name' => $this->resource['interested_name'] ?? '',
            'interested_email' => $this->resource['interested_email'] ?? '',
            'interested_sent' => $this->resource['interested_sent'] ?? '',
            'created_at' => $this->resource['created_at'] ?? '',
            'updated_at' => $this->resource['updated_at'] ?? ''
        ];
    }
}
