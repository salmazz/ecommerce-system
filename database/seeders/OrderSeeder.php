<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()->count(20)->create()->each(function ($order) {
            OrderProduct::factory()->count(3)->create([
                'order_id' => $order->id,
            ]);
        });
    }
}
