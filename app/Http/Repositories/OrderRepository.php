<?php

namespace App\Http\Repositories;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function create(array $data): ?Order;
    public function createItem(Order $order, array $data);
}

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * create initializes a new Order instance with the provided data, saves it to the database, and returns the created Order.
     */
    public function create(array $data): ?Order
    {
        $order = new Order();
        $order = $this->setAttributes($order, $data);
        $order->save();

        return $order;
    }

    /**
     * createItem initializes a new OrderItem instance with the provided data and associates it with the given Order.
     */
    public function createItem(Order $order, array $data)
    {
        $order->items()->create($data);

        return $order;
    }

    /**
     * setAttributes is a helper method to assign attributes to an Order model instance.
     */
    private function setAttributes(Order $model, array $attributes): Order
    {
        if (isset($attributes['total_price'])) {
            $model->total_price = $attributes['total_price'];
        }

        return $model;
    }
}
