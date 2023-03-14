<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function () {
    Route::controller(OrderController::class)->group(function () {
        // delete
        Route::delete('/{order}', 'destroy')->name('admin.orders.destroy');
        Route::delete('/', 'destroyMultiple')->name('admin.orders.destroy-multiple');

        // restore
        Route::put('/{order}/restore', 'restore')->name('admin.orders.restore')->withTrashed();
        Route::put('/restore', 'restoreMultiple')->name('admin.orders.restore-multiple');

        // index
        Route::get('/', 'index')->name('admin.orders.index');

        // create
        Route::post('/', 'store')->name('admin.orders.store');

        // update
        Route::put('/{order}', 'update')->name('admin.orders.update');
    });
});
