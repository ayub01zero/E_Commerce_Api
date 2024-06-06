<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'phone' => $this->phone,
            'address' => $this->address,
            'points' => $this->points,
            'status' => $this->status,
            $this->mergewhen( $request->routeIs('user.index'),[
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]),
        'orders' => OrderResource::collection($this->whenLoaded('orders')),

            'links' => [
                'self' => route('user.index', ['user' => $this->id]),
            ],
         
        ];
    }
}
