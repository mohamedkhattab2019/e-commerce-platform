<?php
namespace App\DTOs;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class OrderDTO
{
    public ?int $user_id;
    public array $items;
    public ?string $guest_token;
    public array $shipping_details;
    public array $payment_details;

    public function __construct(?int $user_id, ?string $guest_token,array $items, array $shipping_details, array $payment_details)
    {
        $this->user_id = $user_id;
        $this->items = $items;
        $this->shipping_details = $shipping_details;
        $this->payment_details = $payment_details;
        $this->guest_token = $guest_token;
    }

    public static function fromArray(array $data): self
    {
        $validator = Validator::make($data, [
            'user_id' => 'nullable|exists:users,id',
            'guest_token' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'shipping_details' => 'required|array',
            'shipping_details.address' => 'required|string',
            'shipping_details.phone' => 'required|string',
            'shipping_details.city' => 'required|string',
            'shipping_details.zip_code' => 'required|string',
            'payment_details' => 'required|array',
            'payment_details.payment_method' => 'required|string',
            'payment_details.transaction_id' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return new self(
            $data['user_id'] ?? null,
            $data['guest_token'] ?? null,
            $data['items'],
            $data['shipping_details'],
            $data['payment_details']
        );
    }
    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'guest_token' => $this->guest_token,
            'items' => $this->items,
            'shipping_details' => $this->shipping_details,
            'payment_details' => $this->payment_details,
        ];
    }
}
