<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'Type' => 'Coupon',
            'attributes' => [
                'name' => $this->coupon_name,
                'validity' => $this->coupon_validity,
                'discount' => $this->coupon_discount,
                'status' => $this->status,
            ],
        ];
    }
}
