<?php

use App\Http\Controllers\Admin\ItemController;
use Illuminate\Support\Facades\Route;

Route::prefix('items')->group(function () {
	Route::controller(ItemController::class)->group(function () {
		// delete
		Route::delete('/{item}', 'destroy')->name('items.destroy');
		Route::delete('/', 'destroyMultiple')->name('items.destroy-multiple');

		// restore
		Route::put('/{item}/restore', 'restore')->name('items.restore')->withTrashed();
		Route::put('/restore', 'restoreMultiple')->name('items.restore-multiple');

		// index
		Route::get('/', 'index')->name('items.index');

		// create
		Route::post('/', 'store')->name('items.store');

		// update
		Route::put('/{item}', 'update')->name('items.update');
	});
});
