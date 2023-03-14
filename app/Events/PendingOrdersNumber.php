<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PendingOrdersNumber implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct()
    {
        //
    }

    public function broadcastOn(): Channel|array
    {
        return new Channel('pending-order-number');
    }

    public function broadcastAs(): string
    {
        return 'pending.order.number';
    }

    public function broadcastWith(): array
    {
        return [
            'pendingOrderNumber' => (new Order())->countPending(),
        ];
    }
}
