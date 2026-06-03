<?php

namespace App\Http\Controllers;

use App\Http\Services\OrderServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $orderServiceInterface;
	public function __construct(
        OrderServiceInterface $orderServiceInterface
	) {
        $this->orderServiceInterface = $orderServiceInterface;
	}

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
		try {
			$this->data = $this->orderServiceInterface->store($request->all());
			$this->message = 'Order created successfully!';
			DB::commit();
		} catch (\Exception $e) {
			DB::rollback();
			$this->message = $e;
			$this->status = $e->getCode() ?: self::CODE_500;
		}

		return $this->response();
    }
}
