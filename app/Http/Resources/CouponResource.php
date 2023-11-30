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
            'Id' => (string) $this->id,
            'Type' => 'Coupon',
            'attributes' => [
                'Name' => $this->coupon_name,
                'Validity' => $this->coupon_validity,
                'Discount' => $this->coupon_discount,
                'Status' => $this->status,
            ],
        ];
    }
}
