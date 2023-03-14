<?php

declare(strict_types=1);

namespace App\Events;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public $order)
    {
        //
    }

    public function broadcastOn(): Channel|array
    {
        return new Channel('orders.'.$this->order->user_id);

        // return [
        // 	new PrivateChannel('user.'.$this->user->id),
        // ];
    }

  public function broadcastAs(): string
  {
      return 'order.status.updated';
  }

  public function broadcastWith(): array
  {
      $orderData = Order::with('user')->find($this->order->id);

      return [
          'order' => new OrderResource($orderData),
      ];
  }
}
