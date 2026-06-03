<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        "data" => "",
        "message" => "API",
        "env" => env('APP_ENV', 'production'),
        "version" => env('APP_VERSION', '1.0.0'),
    ]);
});
