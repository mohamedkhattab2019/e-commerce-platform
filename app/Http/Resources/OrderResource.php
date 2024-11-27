<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'total' => $this->total,
            'status' => $this->status,
            'user' => [
                'name' => $this->user??$this->user?->name,
                'email' => $this->user??$this->user?->email,
            ],
            'userGuestToken' => $this->guest_token,
            'items' => $this->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'name' => $item->product->name_ar,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total_price' => $item->quantity * $item->price,
                ];
            }),
            'shipping_details' => $this->shippingDetails,
            'payment_details' => $this->paymentDetails,
        ];
    }
}
