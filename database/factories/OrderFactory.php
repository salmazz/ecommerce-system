<?php

namespace Database\Factories;

use App\Enums\Order\OrderStatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'total_price' => fake()->randomFloat(2, 50, 1000),
            'status' => fake()->randomElement(array_column(OrderStatusEnum::cases(), 'value')),
        ];
    }
}
