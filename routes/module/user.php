<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('auth')->group(function () {
	Route::controller(UserController::class)->group(function () {
		Route::get('/users', 'index')->name('users.index');
		Route::post('/users', 'store')->name('users.store');
		// Route::get('/users/{user}', 'show')->name('users.show');
		Route::put('/users/{user}', 'update')->name('users.update');
		Route::delete('/users/{user}', 'destroy')->name('users.destroy')->withTrashed();
		Route::delete('/users', 'destroyMultiple')->name('users.destroy-multiple')->withTrashed();
    Route::put('/users/{user}/restore', 'restore')->name('users.restore')->withTrashed();
    Route::put('/users/restore-multiple', 'restoreMultiple')->name('users.restore-multiple')->withTrashed();
	});
});
