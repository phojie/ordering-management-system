<?php

declare(strict_types=1);

namespace App\Http\Controllers\Components;

use App\Http\Resources\OrderResource;
use App\Services\OrderService;

class OrderController
{
    public function show($id)
    {
        abort_unless(\Gate::allows('order-read'), 404);

        $order = (new OrderService())->find($id);

        $order = new OrderResource($order);

        return response()->json($order, 200);
    }
}
