<?php

namespace App\Providers;

use App\Http\Repositories\ExampleRepository;
use App\Http\Repositories\ExampleRepositoryInterface;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\OrderRepositoryInterface;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\ProductRepositoryInterface;
use App\Http\Services\ExampleService;
use App\Http\Services\ExampleServiceInterface;
use App\Http\Services\OrderService;
use App\Http\Services\OrderServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Services
		$this->app->bind(ExampleServiceInterface::class, ExampleService::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);

        // Repositories
		$this->app->bind(ExampleRepositoryInterface::class, ExampleRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
