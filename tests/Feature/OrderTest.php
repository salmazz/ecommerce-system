<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function it_creates_an_order_successfully_with_valid_data()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a couple of products with stock available
        $product1 = Product::factory()->create(['stock' => 10]);
        $product2 = Product::factory()->create(['stock' => 5]);

        // Structure the order data (matching the JSON you expect to receive)
        $orderData = [
            'products' => [
                ['id' => $product1->id, 'quantity' => 2, 'price' => 100.50],
                ['id' => $product2->id, 'quantity' => 1, 'price' => 200.00],
            ]
        ];

        // Simulate an authenticated user making a post request to store the order
        $response = $this->actingAs($user)->postJson('/api/orders', $orderData);

        // Assert that the response is successful
        $response->assertStatus(201);

        // Assert the database has the new order and order product relations
        $this->assertDatabaseHas('orders', ['user_id' => $user->id]);
        $this->assertDatabaseHas('order_product', ['product_id' => $product1->id, 'quantity' => 2]);
        $this->assertDatabaseHas('order_product', ['product_id' => $product2->id, 'quantity' => 1]);

        // Assert the stock has been decreased
        $this->assertEquals(8, $product1->fresh()->stock);
        $this->assertEquals(4, $product2->fresh()->stock);
    }

    #[Test]
    public function it_returns_validation_error_when_required_fields_are_missing()
    {
        // Create a user
        $user = User::factory()->create();

        // Send request with missing product data
        $invalidOrderData = [
            'products' => [
                ['id' => '', 'quantity' => ''], // Invalid product data
            ]
        ];

        // Simulate a post request
        $response = $this->actingAs($user)->postJson('/api/orders', $invalidOrderData);

        // Assert that validation errors are returned
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['products.0.id', 'products.0.quantity']);
    }

    #[Test]
    public function it_fails_when_product_has_insufficient_stock()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a product with limited stock
        $product = Product::factory()->create(['stock' => 1]);

        // Structure the order data with a quantity greater than the stock
        $orderData = [
            'products' => [
                ['id' => $product->id, 'quantity' => 2, 'price' => 100.50], // Quantity exceeds stock
            ]
        ];

        // Simulate an authenticated user making a post request
        $response = $this->actingAs($user)->postJson('/api/orders', $orderData);

        // Assert that the response has an error with a 500 status code
        $response->assertStatus(500);

        // Adjust the assertion to match the actual error structure
        $response->assertJson([
            'message' => 'Product not available or insufficient stock',
        ]);
    }
}
