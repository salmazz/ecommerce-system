<?php

namespace App\Repositories\Order;

use App\Enums\Order\OrderStatusEnum;
use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function getUserOrders($userId, $perPage = 10)
    {
        $query = Order::where('user_id', $userId);

        return $query->paginate($perPage);
    }

    public function getOrderById(int $id)
    {
        return Order::with('products')->findOrFail($id);
    }

    public function createOrder($user, array $products)
    {
        $totalPrice = $this->calculateTotalPrice($products);

        $order = $user->orders()->create([
            'total_price' => $totalPrice,
            'status' => OrderStatusEnum::Pending,
        ]);

        foreach ($products as $product) {
            $order->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price_at_purchase' => $product['price'],
            ]);
        }

        return $order;
    }

    private function calculateTotalPrice(array $products)
    {
        $totalPrice = 0;

        foreach ($products as $product) {
            $totalPrice += $product['price'] * $product['quantity'];
        }

        return $totalPrice;
    }

}
