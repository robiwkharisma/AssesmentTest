<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'order'], function () {
	Route::post('/', [OrderController::class, 'store']);
});


