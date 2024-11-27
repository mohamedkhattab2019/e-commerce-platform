<?php
namespace App\Http\Controllers;

use App\Services\OrderService;
use App\DTOs\OrderDTO;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $userId = $request->user_id ?? null;
        // return $userId;
        $data['user_id'] = $userId; // Assign user_id if authenticated, null otherwise
        $data['guest_token'] = $request->guest_token;
        // Retrieve guest token from the header

        $orderDTO = OrderDTO::fromArray($data);

        $order = $this->orderService->createOrder($orderDTO->toArray());
        return new OrderResource($order);
    }

    public function show($id)
    {
        $order = $this->orderService->findOrderById($id);
        return new OrderResource($order);
    }
}
