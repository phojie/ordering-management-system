<?php

declare(strict_types=1);

namespace App\Events;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrder implements ShouldBroadcast
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
        return new Channel('new-order');
    }

    public function broadcastAs(): string
    {
        return 'new.order';
    }

    public function broadcastWith(): array
    {
        $orderData = Order::with('user')->find($this->order->id);

        return [
            'order' => new OrderResource($orderData),
        ];
    }
}
