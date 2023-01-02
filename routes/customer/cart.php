<?php

use App\Http\Controllers\Customer\CartController;
use Illuminate\Support\Facades\Route;

Route::prefix('carts')->group(function () {
	Route::controller(CartController::class)->group(function () {
		// index
		Route::get('/', 'index')->name('customer.carts.index');

		// store
		Route::post('/', 'store')->name('customer.carts.store');

    // destroy
    Route::delete('/{cart}', 'destroy')->name('customer.carts.destroy');
	});
});
