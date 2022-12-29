<?php

use App\Http\Controllers\Admin\ItemController;
use Illuminate\Support\Facades\Route;

Route::prefix('items')->group(function () {
	Route::controller(ItemController::class)->group(function () {
		// delete
		Route::delete('/{item}', 'destroy')->name('admin.items.destroy');
		Route::delete('/', 'destroyMultiple')->name('admin.items.destroy-multiple');

		// restore
		Route::put('/{item}/restore', 'restore')->name('admin.items.restore')->withTrashed();
		Route::put('/restore', 'restoreMultiple')->name('admin.items.restore-multiple');

		// index
		Route::get('/', 'index')->name('admin.items.index');

		// create
		Route::post('/', 'store')->name('admin.items.store');

		// update
		Route::put('/{item}', 'update')->name('admin.items.update');
	});
});
