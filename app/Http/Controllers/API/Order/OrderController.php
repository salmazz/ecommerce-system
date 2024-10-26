<?php

namespace App\Http\Controllers\API\Order;

use App\Common\Helpers\JsonResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrder;
use App\Http\Resources\Order\OrderCollection;
use App\Http\Resources\Order\OrderResource;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $userId = Auth::id();

        $orders = $this->orderService->getUserOrders($userId,$request->get('per_page', 10));

        return JsonResponseHelper::paginatedJsonResponse('Orders retrieved successfully', ['items' => new OrderCollection($orders)], 200);
    }

    public function show($id)
    {
        $order = $this->orderService->getOrderById($id);

        if (!$order) {
            return JsonResponseHelper::jsonResponse('Order not found', [], 404);
        }

        return JsonResponseHelper::jsonResponse('Order retrieved successfully', [new OrderResource($order)], 200);
    }

    public function store(StoreOrder $request)
    {
        $order = $this->orderService->createOrder($request->user(), $request->validated());

        return JsonResponseHelper::jsonResponse('Order created successfully', [new OrderResource($order)], 201);
    }
}
