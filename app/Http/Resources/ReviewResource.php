<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'Type' => 'Reviews',
            'attributes' => [
                'order_id' => $this->order_id,
                'user_id' => $this->user_id,
                'comment' => $this->comment,
                'rating' => $this->rating,
                'status' => $this->status,
            ],
        ];
    }
}
