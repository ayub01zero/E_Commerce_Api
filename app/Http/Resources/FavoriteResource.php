<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'Type' => 'Favorites',
            'attributes' => [
                'product_id' => $this->product_id,
                'user_id' => $this->user_id,
            ],
        ];
    }
}
