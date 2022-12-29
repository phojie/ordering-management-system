<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// SET main domain to the route group below
// Route::domain(config('app.url'))->group(function () {
	Route::get('/', function () {
		return Inertia::render('Welcome', [
			'canLogin' => Route::has('login'),
			'canRegister' => Route::has('register'),
			'laravelVersion' => Application::VERSION,
			'phpVersion' => PHP_VERSION,
		]);
	})->name('index');

	require __DIR__.'/auth/index.php';
// });

// SET subdomain admin to the route group below
// Route::domain('admin.'.config('app.url'))->middleware(['auth'])->group(function () {
// 	require __DIR__.'/admin/user.php';
// 	require __DIR__.'/admin/role.php';
// 	require __DIR__.'/admin/index.php';

// 	require __DIR__.'/admin/category.php';
// 	require __DIR__.'/admin/item.php';
// });

Route::middleware(['auth', 'customer'])->group(function () {
  require __DIR__.'/customer/index.php';
});


Route::prefix('admin')->middleware(['auth'])->group(function () {
	require __DIR__.'/admin/user.php';
	require __DIR__.'/admin/role.php';
	require __DIR__.'/admin/index.php';

	require __DIR__.'/admin/category.php';
	require __DIR__.'/admin/item.php';
});

require __DIR__.'/components/index.php';

