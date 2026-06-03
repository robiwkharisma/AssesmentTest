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
    /**
     * Find a product by ID with a database lock for update to prevent race conditions
     */
    public function find(int $id): ?Product
    {
        // lockForUpdate() forces other requests to queue on this product row
        return Product::lockForUpdate()->find($id);
    }

    /**
     * decreaseStock atomically decreases the stock of a product by a specified quantity.
     */
    public function decreaseStock(Product $product, int $quantity): ?Product
    {
        // decrement() is atomic and will prevent race conditions when multiple
        $product->decrement('stock', $quantity);

        return $product;
    }

    /**
     * create initializes a new Product instance with the provided attributes and returns it.
     */
    public function create(array $attributes): Product
    {
        $model = new Product();
        return $this->setAttributes($model, $attributes);
    }

    /**
     * setAttributes is a helper method to assign attributes to a Product model instance.
     */
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
