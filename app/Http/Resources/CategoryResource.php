<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Id' => (string) $this->id,
            'Type' => 'Category',
            'attributes' => [
                'Name' => $this->category_name,
                'img_url' => $this->image,
            ],
        ];
    }
}
