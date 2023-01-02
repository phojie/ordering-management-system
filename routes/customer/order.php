<?php

use App\Http\Controllers\Customer\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function () {
	Route::controller(OrderController::class)->group(function () {
		// index
		Route::get('/', 'index')->name('customer.orders.index');

		// store
		Route::post('/', 'store')->name('customer.orders.store');
	});
});
