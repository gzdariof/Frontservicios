<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use app\Services\ServicioService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(ServicioService::class, function ($app) {
            return new ServicioService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
