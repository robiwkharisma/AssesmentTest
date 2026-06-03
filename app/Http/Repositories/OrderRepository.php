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
    public function create(array $data): ?Order
    {
        $order = new Order();
        $order = $this->setAttributes($order, $data);
        $order->save();

        return $order;
    }

    public function createItem(Order $order, array $data)
    {
        $order->items()->create($data);

        return $order;
    }

    private function setAttributes(Order $model, array $attributes): Order
    {
        if (isset($attributes['total_price'])) {
            $model->total_price = $attributes['total_price'];
        }

        return $model;
    }
}
