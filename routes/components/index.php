<?php

declare(strict_types=1);

use App\Http\Controllers\Components\CartController;
use App\Http\Controllers\Components\CategoryController;
use App\Http\Controllers\Components\OrderController;
use App\Http\Controllers\Components\PermissionController;
use App\Http\Controllers\Components\ProductController;
use App\Http\Controllers\Components\RoleController;
use App\Http\Controllers\Components\TemporaryFileController;
use App\Http\Controllers\Components\UserController;

// unauthorized
Route::get('components/categories/random', [CategoryController::class, 'random'])->name('components.categories.random');
Route::get('components/products/random', [ProductController::class, 'random'])->name('components.products.random');
Route::get('components/carts/count', [CartController::class, 'count'])->name('components.carts.count');

// authorized
Route::prefix('components')->middleware('auth')->group(function () {
    // roles
    Route::get('roles', [RoleController::class, 'index'])->name('components.roles');
    Route::get('roles/{id}', [RoleController::class, 'show'])->name('components.roles.show');

    // permissions
    Route::get('permissions', [PermissionController::class, 'index'])->name('components.permissions');

    // temporary-files
    Route::post('temporary-file', [TemporaryFileController::class, 'store'])->name('components.temporary-file.store');
    Route::delete('temporary-file/{folder}', [TemporaryFileController::class, 'destroy'])->name('components.temporary-file.destroy');

    // users
    Route::get('users/{id}', [UserController::class, 'show'])->name('components.users.show');

    // categories
    Route::get('categories', [CategoryController::class, 'index'])->name('components.categories');
    Route::get('categories/{id}', [CategoryController::class, 'show'])->name('components.categories.show');

    // products
    Route::get('products', [ProductController::class, 'index'])->name('components.products');
    Route::get('products/{id}', [ProductController::class, 'show'])->name('components.products.show');

    // orders
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('components.orders.show');
});
