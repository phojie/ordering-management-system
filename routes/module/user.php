<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('auth')->group(function () {
	Route::controller(UserController::class)->group(function () {
		Route::get('/users', 'index')->name('users.index');
		Route::post('/users', 'store')->name('users.store');
		// Route::get('/users/{user}', 'show')->name('users.show');
		Route::put('/users/{user}', 'update')->name('users.update');
    // Route::get('/users/{user}/edit', 'edit')->name('users.edit');
		Route::delete('/users/{user}', 'destroy')->name('users.destroy');
		Route::delete('/users', 'destroyMultiple')->name('users.destroy-multiple');
	});
});
