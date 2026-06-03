<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::group(['prefix' => 'user', 'middleware' => 'example:example'], function () {
//     Route::get('example', [ExampleController::class, 'example'])->middleware('example:example')->name('example.example');
// });
Route::group(['prefix' => 'user'], function () {
	Route::get('/', [ExampleController::class, 'example']);
});

Route::group(['prefix' => 'order'], function () {
	Route::post('/', [OrderController::class, 'store']);
});


