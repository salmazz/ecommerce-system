<?php
namespace App\Repositories\Order;

interface OrderRepositoryInterface
{
    public function getUserOrders($userId, $perPage = 10);
    public function getOrderById(int $id);
    public function createOrder($user, array $products);
}
