<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/admin', function () {
        return Inertia::render('Admin/Index');
    });

    Route::get('/admin/menus', function () {
        return Inertia::render('Admin/Menus', [
            'menus' => [],
        ]);
    });
});

require __DIR__ . '/module/auth.php';
require __DIR__ . '/module/user.php';
