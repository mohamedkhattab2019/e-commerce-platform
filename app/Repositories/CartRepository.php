<?php
namespace App\Repositories;

use App\Models\Cart;

class CartRepository
{
    public function getCart($userId = null, $guestToken = null)
    {
        return Cart::with('product')
            ->where(function ($query) use ($userId, $guestToken) {
                if ($userId) {
                    $query->where('user_id', $userId);
                }
    
                if ($guestToken) {
                    $query->orWhere('guest_token', $guestToken);
                }
            })
            ->where(function ($query) {
                $query->whereNotNull('user_id')->orWhereNotNull('guest_token');
            })
            ->get();
    }
    public function addToCart($userId = null, $guestToken = null, $productId)
    {
        // Find or create the cart item
        $cartItem = Cart::firstOrCreate(
            [
                'user_id' => $userId,
                'guest_token' => $guestToken,
                'product_id' => $productId,
            ],
            [
                'quantity' => 0, // Default to 0 for new cart items
            ]
        );

        // Increment quantity by 1
        $cartItem->quantity += 1;
        $cartItem->save();

        return $cartItem;
    }
    public function updateQuantity($userId = null, $guestToken = null, $productId, $quantity)
    {
        $cartItem = Cart::where('product_id', $productId)
            ->where(function ($query) use ($userId, $guestToken) {
                $query->where('user_id', $userId)->orWhere('guest_token', $guestToken);
            })
            ->first();

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }
    }

    public function removeProduct($userId = null, $guestToken = null, $productId)
    {
        Cart::where('product_id', $productId)
            ->where(function ($query) use ($userId, $guestToken) {
                $query->where('user_id', $userId)->orWhere('guest_token', $guestToken);
            })
            ->delete();
    }

    public function clearCart($userId = null, $guestToken = null)
    {
        Cart::where(function ($query) use ($userId, $guestToken) {
            $query->where('user_id', $userId)->orWhere('guest_token', $guestToken);
        })->delete();
    }
}
