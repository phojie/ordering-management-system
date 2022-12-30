<?php

use Illuminate\Foundation\Application;
use Inertia\Inertia;

Route::get('/', function () {
  $randomCategories = \App\Models\Category::inRandomOrder()->limit(3)->get();

	return Inertia::render('Index', [
    'categories' => $randomCategories,
	]);
})->name('index');

Route::get('/about', function () {

	return Inertia::render('About');
})->name('about');

Route::get('/contact-us', function () {
	return Inertia::render('ContactUs');
})->name('contact-us');
