<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\FlashNotification;
use App\Services\OrderService;
use Gate;
use Illuminate\Http\Request;

class OrderController
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('order-list'), 404);

        // set query
        $query = (new OrderService())->get($request);

        // set pagination
        $orders = $query->paginate($request->rows ?? config('jie.per_page'))->appends($request->all());

        // set resource
        $query = OrderResource::collection($orders);

        return inertia('Admin/Orders/Index', [
            'orders' => $query,
        ]);
    }

    public function show($id)
    {
        abort_unless(Gate::allows('order-read'), 404);

        $order = (new OrderService())->find($id);

        $order = new OrderResource($order);

        return inertia('Admin/Orders/Show', [
            'order' => $order,
        ]);
    }

  // update
    public function update(OrderRequest $request, Order $order)
    {
        abort_unless(Gate::allows('order-update'), 404);

        (new OrderService())->update($request, $order);

        (new FlashNotification())->update("Order number # $order->order_number");

        return redirect()->back();
    }

    public function destroy(Order $order)
    {
        abort_unless(Gate::allows('order-delete'), 404);

        (new OrderService())->delete($order->id);

        (new FlashNotification())->destroy("Order number # $order->order_number");

        return redirect()->back();
    }

    public function destroyMultiple(Request $request)
    {
        Gate::authorize('order-delete');

        (new OrderService())->deleteMultiple($request->ids);

        (new FlashNotification())->destroy(count($request->ids).' order number');

        return redirect()->back();
    }
}
