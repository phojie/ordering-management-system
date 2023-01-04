<?php

namespace App\Http\Controllers\Components;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController
{
	public function show($id)
	{
    abort_unless(\Gate::allows('order-show'), 404);

    $order = (new OrderService())->find($id);

    $order = new OrderResource($order);

    return response()->json($order, 200);
	}
}
