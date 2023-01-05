<?php

use App\Events\NewOrder;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::domain('admin.'.config('app.url'))->group(function () {
// 	Route::middleware('auth:sanctum')->group(function () {
// 	});
// });

// trigger broadcast event
// Route::get('/broadcast', function () {
// 	$order = Order::first();
// 	OrderStatusUpdated::dispatch($order);

//   dd($order);

// 	return 'done';
// });

Route::get('/broadcast', function () {
	$order = Order::first();
	// OrderStatusUpdated::dispatch($order);
	NewOrder::dispatch($order);

	dd($order);

	return 'done';
});
