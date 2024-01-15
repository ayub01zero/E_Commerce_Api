<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'Type' => 'Sliders',
            'attributes' => [
                'Product_id' => $this->product_id,
                'img_url' => env('APP_URL') . $this->image,
            ],
        ];
    }
}
