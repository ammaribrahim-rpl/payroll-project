<?php
// app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router; // Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Router $router): void // Inject Router
    {
        $router->aliasMiddleware('isAdmin', \App\Http\Middleware\AdminMiddleware::class);
        $router->aliasMiddleware('isKaryawan', \App\Http\Middleware\KaryawanMiddleware::class);
    }
}