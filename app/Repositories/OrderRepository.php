<?php
namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;

class OrderRepository
{
    public function create(array $orderData, array $items, array $shippingDetails, array $paymentDetails)
    {
        $order = Order::create($orderData);

        // Create order items
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['total'],
            ]);
        }

        // Create shipping details
        $order->shippingDetails()->create($shippingDetails);
        // $paymentDetails['amount'] = $orderData['total'];
        // Create payment details
        $order->paymentDetails()->create($paymentDetails);

        return $order->load('items.product', 'shippingDetails', 'paymentDetails');
    }
    public function findById($id)
    {
        return Order::with(['items.product', 'shippingDetails', 'paymentDetails'])->findOrFail($id);
    }
    public function findOrdersByUserOrGuest($userId, $guestToken)
{
    $query = Order::with(['items.product', 'shippingDetails', 'paymentDetails']);

    if ($userId) {
        $query->where('user_id', $userId);
    } elseif ($guestToken) {
        $query->where('guest_token', $guestToken);
    }

    return $query->get();
}

}
