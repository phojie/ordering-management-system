<?php

declare(strict_types=1);

use App\Http\Controllers\Customer\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function () {
    Route::controller(OrderController::class)->group(function () {
        // index
        Route::get('/', 'index')->name('customer.orders.index');

        // store
        Route::post('/', 'store')->name('customer.orders.store');

        // show
        Route::get('/{order}', 'show')->name('customer.orders.show');
    });
});
