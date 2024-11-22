<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();

        return [
            'order_id' => Order::inRandomOrder()->first()->id,
            'product_id' => $product->id,
            'quantity' => fake()->numberBetween(1, 5),
            'price_at_purchase' => $product->price,
        ];
    }
}
