<?php

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
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

    // get users
    Route::get('/admin/users', function () {
        $users = User::query()
                    ->where('id', '!=', auth()->user()->id)
                    ->paginate(15);

        $query =  UserResource::collection($users);

        return Inertia::render('Admin/Users', [
            'users' => $query
        ]);
    });

    // store user
    Route::post('/admin/users', function (UserRequest $userRequest) {
        $validator = $userRequest->validated();
        User::create($validator);
        return redirect()->back()->with('success', 'User created successfully.');
    })->name( 'users.store');

    // delete users
    Route::delete('/admin/users/{user}', function (User $user) {
        $user->delete();
        return redirect()->back();
    })->name('users.delete');

    // delete multiple users
    Route::delete('/admin/users', function () {
        User::whereIn('id', request('ids'))->delete();
        return redirect()->back();
    })->name('users.delete-multiple');
});

require __DIR__ . '/auth.php';
