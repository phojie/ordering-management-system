<?php

use App\Http\Resources\UserCollection;
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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', function () {
    return Inertia::render('Admin/Index');
});

Route::get('/admin/menus', function () {
    return Inertia::render('Admin/Menus', [
        // 'menus' => \App\Models\Menu::all(),
    ]);
});

Route::get('/admin/users', function () {
    sleep(5);
    return Inertia::render('Admin/Users', [
        'users' => \App\Models\User::all()
    ]);
});

require __DIR__ . '/auth.php';
