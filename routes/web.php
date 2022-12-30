<?php

use Illuminate\Support\Facades\Route;

// auth routes
require __DIR__.'/auth/index.php';

// public routes
require __DIR__.'/public/index.php';

// customer routes
Route::middleware(['auth', 'customer'])->group(function () {
	require __DIR__.'/customer/index.php';
});

// admin routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
	require __DIR__.'/admin/user.php';
	require __DIR__.'/admin/role.php';
	require __DIR__.'/admin/index.php';

	require __DIR__.'/admin/category.php';
	require __DIR__.'/admin/item.php';
});

// components routes
require __DIR__.'/components/index.php';
