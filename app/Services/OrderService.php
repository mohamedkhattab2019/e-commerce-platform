<?php
namespace App\Services;

use App\Exceptions\InsufficientInventoryException;
use App\Models\Cart;
use App\Repositories\OrderRepository;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected OrderRepository $orderRepository;
    protected CartService $cartService;

    public function __construct(OrderRepository $orderRepository, CartService $cartService)
    {
        $this->orderRepository = $orderRepository;
        $this->cartService = $cartService;
    }

    public function createOrder(array $data)
    {
        return DB::transaction(function () use ($data) {
            $subtotal = 0;
            $tax = 0;
            $total = 0;
            $items = [];
            $userId = $data['user_id'];
            $guestToken = $data['guest_token'];

            foreach ($data['items'] as $item) {
                $product = Inventory::where('product_id', $item['product_id'])->first();
                if (!$product || $product->quantity < $item['quantity']) {
                    throw new InsufficientInventoryException("Insufficient stock for product ID {$item['product_id']}");

                }

                // Reduce inventory
                $product->quantity -= $item['quantity'];
                $product->save();

                $price = $product->product->price;
                $itemTotal = $price * $item['quantity']; 
                $subtotal += $price * $item['quantity'];

                $items[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $price,
                    'total' => $itemTotal,
                ];
                $this->cartService->removeProduct($userId, $guestToken,$item['product_id']);
            }



            // Calculate tax (e.g., 10%)
            $tax = $data['payment_details']['tax'];
            $total = $data['payment_details']['amount'];

            $orderData = [
                'user_id' => $userId,
                'subtotal' => $subtotal,
                'guest_token' => $guestToken,
                'tax' => $tax,
                'total' => $total,
                'status' => 'completed',
            ];

            return $this->orderRepository->create($orderData, $items, $data['shipping_details'], $data['payment_details']);
        });
    }
    public function findOrderById($id)
    {
        return $this->orderRepository->findById($id);
    }
    public function getUserOrders($userId, $guestToken)
{
    if (!$userId && !$guestToken) {
        return [];
    }

    return $this->orderRepository->findOrdersByUserOrGuest($userId, $guestToken);
}

}
