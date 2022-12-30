<?php

use Illuminate\Foundation\Application;
use Inertia\Inertia;

Route::get('/', function () {
	return Inertia::render('Index', [
		'canLogin' => Route::has('login'),
		'canRegister' => Route::has('register'),
		'laravelVersion' => Application::VERSION,
		'phpVersion' => PHP_VERSION,
	]);
})->name('index');
