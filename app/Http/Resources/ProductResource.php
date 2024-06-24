<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Id' => (string)$this->id,
            'Type' => 'Products',
            'attributes' => [
                'product_name' => $this->product_name,
                'product_code' => $this->product_code,
                'product_qty' => $this->product_qty,
                'product_tags' => $this->product_tags,
                'weight' => $this->weight,
                'selling_price' => $this->selling_price,
                'discount_price' => $this->discount_price,
                'short_des' => $this->short_des,
                'long_des' => $this->long_des,
                'show_slider' => $this->show_slider,
                'week_deals' => $this->week_deals,
                'special_offer' => $this->special_offer,
                'new_products' => $this->new_products,
                'discount_products' => $this->discount_products,
                'status' => $this->status,
                [
                    'realtionships' => [
                        'Category' => new CategoryResource($this->category),
                        'Images' => PhotoResource::collection($this->images),
                    ],
                ]
            ],
        ];
    }
}
