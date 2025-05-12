<?php
protected $routeMiddleware = [
    // ... middleware lainnya
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'karyawan' => \App\Http\Middleware\KaryawanMiddleware::class,
];