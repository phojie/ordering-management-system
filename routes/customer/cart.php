<?php

use App\Http\Controllers\Customer\CartController;
use Illuminate\Support\Facades\Route;

Route::prefix('carts')->group(function () {
	Route::controller(CartController::class)->group(function () {
    // checkout
    Route::post('/checkout', 'checkout')->name('customer.carts.checkout');

		// index
		Route::get('/', 'index')->name('customer.carts.index');

		// store
		Route::post('/', 'store')->name('customer.carts.store');

    // update
    Route::put('/{cart}', 'update')->name('customer.carts.update');

    // destroy
    Route::delete('/{cart}', 'destroy')->name('customer.carts.destroy');
	});
});
