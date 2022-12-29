<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('categories')->group(function () {
	Route::controller(CategoryController::class)->group(function () {
		// delete
		Route::delete('/{category}', 'destroy')->name('categories.destroy');
		Route::delete('/', 'destroyMultiple')->name('categories.destroy-multiple');

		// restore
		Route::put('/{category}/restore', 'restore')->name('categories.restore')->withTrashed();
		Route::put('/restore', 'restoreMultiple')->name('categories.restore-multiple');

		// index
		Route::get('/', 'index')->name('categories.index');

		// create
		Route::post('/', 'store')->name('categories.store');

		// update
		Route::put('/{category}', 'update')->name('categories.update');
	});
});
