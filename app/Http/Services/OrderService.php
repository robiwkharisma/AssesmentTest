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
