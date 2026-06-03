<?php

namespace App\Http\Repositories;

use App\Models\Order;
use App\Models\Product;

interface ProductRepositoryInterface
{
    public function find(int $id): ?Product;
    public function decreaseStock(Product $product, int $quantity): ?Product;
    public function create(array $attributes): Product;
}

class ProductRepository implements ProductRepositoryInterface
{
    public function find(int $id): ?Product
    {
        // lockForUpdate() forces other requests to queue on this product row
        return Product::lockForUpdate()->find($id);
    }

    public function decreaseStock(Product $product, int $quantity): ?Product
    {
        $product->decrement('stock', $quantity);

        return $product;
    }

    public function create(array $attributes): Product
    {
        $model = new Product();
        return $this->setAttributes($model, $attributes);
    }

    private function setAttributes(Product $model, array $attributes): Product
    {
        if (isset($attributes['name'])) {
            $model->name = $attributes['name'];
        }

        if (isset($attributes['price'])) {
            $model->price = $attributes['price'];
        }

        if (isset($attributes['stock'])) {
            $model->stock = $attributes['stock'];
        }

        return $model;
    }
}
