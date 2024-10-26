<?php
namespace App\Services\Order;
use App\Events\OrderPlaced;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Product\ProductRepository;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OrderService{

    protected $orderRepository, $productRepository;

    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    public function getUserOrders($userId, $perPage = 10)
    {
        return $this->orderRepository->getUserOrders($userId, $perPage);
    }

    public function getOrderById($id)
    {
        return $this->orderRepository->getOrderById($id);
    }

    public function createOrder($user, array $products)
    {
        return DB::transaction(function () use ($user, $products) {
            if (!isset($products['products']) || !is_array($products['products'])) {
                throw new Exception('Invalid products data format.');
            }

            $productsCollection = collect($products['products']);

            $productsCollection->each(function ($product) {
                $productData = $this->productRepository->getProductById($product['id']);

                if (!$productData || $productData->stock < $product['quantity']) {
                    throw new Exception('Product not available or insufficient stock');
                }
            });

            $order = $this->orderRepository->createOrder($user, $products['products']);

            $productsCollection->each(function ($product) {
                $this->productRepository->decreaseStock($product['id'], $product['quantity']);
            });

            event(new OrderPlaced($order));

            return $order;
        });
    }
}
