<?php

namespace App\Http\Services;

use App\Http\Repositories\OrderRepositoryInterface;
use App\Http\Repositories\ProductRepositoryInterface;
use App\Models\Order;
use App\Models\Product;

interface OrderServiceInterface
{
    public function store(array $data);
}

class OrderService implements OrderServiceInterface
{
    protected $orderRepository;
    protected $productRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * store processes an order by validating product availability, updating stock, and creating order records.
     * 
     * Steps:
     * 1. Validates that the product exists and has sufficient stock for the requested quantity.
     * 2. Decreases the product stock atomically to prevent race conditions during Flash Sale.
     * 3. Creates a new Order record with the total price calculated from the product price and quantity.
     * 4. Creates an OrderItem record associated with the Order for the purchased product.
     * 5. Returns the created Order instance.
     * 
     * Error Handling:
     * - Throws an exception if the product is not found or if the stock is insufficient, with appropriate error messages and HTTP status codes.
     */
    public function store(array $data)
    {
        $product = $this->productRepository->find($data['product_id']);

        if (!$product) {
            throw new \Exception("Produk tidak ditemukan.", 400);
        }

        if ($product->stock < $data['quantity']) {
            throw new \Exception("Stok produk tidak mencukupi untuk Flash Sale.", 400);
        }

        // decrease stock
        $this->productRepository->decreaseStock($product, $data['quantity']);

        // create order
        $order = $this->orderRepository->create([
            'total_price' => $product->price * $data['quantity']
        ]);

        // create order item
        $this->orderRepository->createItem($order, [
            'product_id' => $product->id,
            'quantity' => $data['quantity'],
            'price' => $product->price
        ]);

        return $order;
    }
}
