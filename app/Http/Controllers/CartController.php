<?php
namespace App\Http\Controllers;

use App\Exceptions\InsufficientInventoryException;
use App\Services\CartService;
use App\Http\Resources\CartResource;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $userId = $request->user()->id ?? null;
        $guestToken = $request->query('guest_token');
        $cart =$this->cartService->getCart($userId, $guestToken);

        return response()->json(['data' => CartResource::collection($cart)], status: 200);
    }

    public function addToCart(Request $request)
    {
        $userId = $request->user_id ?? null;
        $guestToken = $request->guest_token;
        
        $cart = $this->cartService->addToCart($userId, $guestToken, $request->product_id);
        return response()->json(['data' => CartResource::collection($cart)], status: 201);
    }

    public function updateQuantity(Request $request)
    {
        $userId = $request->user_id ?? null;
        $guestToken = $request->guest_token;

        $cart = $this->cartService->updateQuantity($userId, $guestToken, $request->product_id, $request->quantity);
        return response()->json(['data' => CartResource::collection($cart)], status: 201);
    }

    public function destroy(Request $request, $productId)
    {
        $userId = $request->user_id ?? null;
        $guestToken = $request->guest_token;
        $cart = $this->cartService->removeProduct($userId, $guestToken, $productId);
        return response()->json(
          [
                    'message' => 'Product removed from cart' , 
                    'data'=> CartResource::collection($cart)
                ]);
    }

    public function clearCart(Request $request)
    {
        $userId = $request->user_id ?? null;
        $guestToken = $request->guest_token;

        $cart = $this->cartService->clearCart($userId, $guestToken);
        return response()->json([
            'message' => 'Cart Cleared successfully!' , 
            'data'=> CartResource::collection($cart)
        ]);
    }
}
