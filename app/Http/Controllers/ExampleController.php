<?php

namespace App\Http\Controllers;

use App\Http\Services\ExampleServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExampleController extends Controller
{
    protected $exampleService;
	public function __construct(
        ExampleServiceInterface $exampleService
	) {
        $this->exampleService = $exampleService;
	}

    public function example(Request $request)
    {
        DB::beginTransaction();
		try {
			$this->data = $this->exampleService->example();
			$this->message = 'Success';
			DB::commit();
		} catch (\Exception $e) {
			DB::rollback();
			$this->message = $e;
			$this->status = self::CODE_500;
		}

		return $this->response();
    }
}
