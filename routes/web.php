<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

// auth routes
require __DIR__.'/auth/index.php';

// public routes
require __DIR__.'/public/index.php';
require __DIR__.'/public/category.php';
require __DIR__.'/public/product.php';

// customer routes
Route::middleware(['auth', 'customer'])->group(function () {
    require __DIR__.'/customer/index.php';
    require __DIR__.'/customer/cart.php';
    require __DIR__.'/customer/order.php';
});

// admin routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    require __DIR__.'/admin/user.php';
    require __DIR__.'/admin/role.php';
    require __DIR__.'/admin/index.php';

    require __DIR__.'/admin/category.php';
    require __DIR__.'/admin/product.php';
    require __DIR__.'/admin/order.php';
});

// components routes
require __DIR__.'/components/index.php';

// broadcasting/auth
Route::post('/broadcasting/auth', function () {
    return Broadcast::auth(request());
});
