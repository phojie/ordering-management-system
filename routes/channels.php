<?php

use App\Broadcasting\OrderChannel;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// Broadcast::channel('orders.{orderId}', function (User $user, int $orderId) {
//   // return $user->id === Order::findOrNew($orderId)->user_id;
//   return true;
// });

// Broadcast::channel('user.{userId}', function (User $user, int $userId) {
//   return true;
// });

Broadcast::channel('orders.{userId}', OrderChannel::class);


