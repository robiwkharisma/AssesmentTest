<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Http\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * OrderServiceTest
 * 
 * Functional tests for the OrderService class.
 * Tests the store method to ensure orders and order items are created correctly.
 */
class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $orderService;

    /**
     * Set up the test environment before each test.
     * Initializes the OrderService instance from the service container.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = app(OrderService::class);
    }

    /**
     * Test that the store method creates an order successfully.
     * 
     * Verifies that:
     * - An Order instance is returned
     * - The order is persisted in the database
     */
    public function test_store_creates_order_successfully()
    {
        // Arrange: Create a test product with a price
        $product = Product::factory()->create(['price' => 100]);

        // Prepare test data for order creation
        $data = [
            'product_id' => $product->id,
            'quantity' => 2,
        ];

        // Act: Call the store method
        $order = $this->orderService->store($data);

        // Assert: Verify the order was created correctly
        $this->assertInstanceOf(Order::class, $order);
        $this->assertDatabaseHas('orders', ['id' => $order->id]);
    }

    /**
     * Test that the store method creates an order item with correct data.
     * 
     * Verifies that:
     * - An order item is created and linked to the order
     * - The product_id and quantity are stored correctly
     */
    public function test_store_creates_order_item_with_correct_data()
    {
        // Arrange: Create a test product
        $product = Product::factory()->create(['price' => 100]);

        // Prepare test data for order creation
        $data = [
            'product_id' => $product->id,
            'quantity' => 3,
        ];

        // Act: Call the store method
        $order = $this->orderService->store($data);

        // Assert: Verify the order item was created with correct attributes
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);
    }

    /**
     * Test that the store method calculates the total price correctly.
     * Verifies that:
     * - The total_price is calculated as (product price × quantity)
     * - The calculation is accurate
     */
    public function test_store_calculates_total_price_correctly()
    {
        // Arrange: Create a test product with a known price
        $product = Product::factory()->create(['price' => 50]);

        // Prepare test data (quantity: 4, price per unit: 50)
        $data = [
            'product_id' => $product->id,
            'quantity' => 4,
        ];

        // Act: Call the store method
        $order = $this->orderService->store($data);

        // Assert: Verify total price calculation (50 × 4 = 200)
        $this->assertEquals(200, $order->total_price);
    }
}