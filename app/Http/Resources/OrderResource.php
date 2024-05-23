<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'includes' => new UserResource($this->whenLoaded('user')),
            'amount' => $this->amount,
            'notes' => $this->notes,
            'payment_method' => $this->payment_method,
            'invoice_no' => $this->invoice_no,
            $this->mergewhen( $request->routeIs('orders.index'),[
            'order_date' => $this->order_date,
            'order_month' => $this->order_month,
            'order_year' => $this->order_year,
            ]),
            'return_date' => $this->return_date,
            'return_order' => $this->return_order,
            'status' => $this->status,
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,


            'links' => [
                'self' => route('orders.index', ['order' => $this->id]),
            ],
        ];
    }
}
