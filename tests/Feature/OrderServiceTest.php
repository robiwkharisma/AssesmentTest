<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Http\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = app(OrderService::class);
    }

    public function test_store_creates_order_successfully()
    {
        $product = Product::factory()->create(['price' => 100]);

        $data = [
            'product_id' => $product->id,
            'quantity' => 2,
        ];

        $order = $this->orderService->store($data);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertDatabaseHas('orders', ['id' => $order->id]);
    }

    public function test_store_creates_order_item_with_correct_data()
    {
        $product = Product::factory()->create(['price' => 100]);

        $data = [
            'product_id' => $product->id,
            'quantity' => 3,
        ];

        $order = $this->orderService->store($data);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);
    }

    public function test_store_calculates_total_price_correctly()
    {
        $product = Product::factory()->create(['price' => 50]);

        $data = [
            'product_id' => $product->id,
            'quantity' => 4,
        ];

        $order = $this->orderService->store($data);

        $this->assertEquals(200, $order->total_price);
    }
}