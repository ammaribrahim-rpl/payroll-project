<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
    public function boot(): void
    {
        // Registrasi middleware alias
        Route::aliasMiddleware('isAdmin', \App\Http\Middleware\AdminMiddleware::class);
        Route::aliasMiddleware('isKaryawan', \App\Http\Middleware\KaryawanMiddleware::class);
    }
}