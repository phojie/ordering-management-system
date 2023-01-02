<?php

namespace App\Http\Controllers\Customer;

use App\Actions\Generate;
use App\Http\Requests\OrderRequest;
use App\Models\Order;

class OrderController
{
	public function store(OrderRequest $request)
	{
\DB::transaction(function () use($request) {
  $order = Order::create([
    'name' => $request->name,
    'order_number' => $request->orderNumber,
    'email' => $request->email,
    'phone' => $request->phone,
    'address' => $request->address,
    'city' => $request->city,
    'province' => $request->province,
    'postal_code' => $request->postalCode,
    'status' => 'pending',

    'total_amount' => $request->totalAmount,
    'taxes_amount' => $request->taxesAmount,
    'shipping_amount' => $request->shippingAmount,

    'user_id' => $request->user()->id,
  ]);

  $orderVariants = collect($request->orderVariants)->map(function ($variant) use ($order) {
    return [
      'order_id' => $order->id,
      'variant_id' => $variant['variantId'],
      'product_id' => $variant['productId'],
      'quantity' => $variant['quantity'],
      'price' => $variant['price'],
      'total' => $variant['total'],
    ];
  });

  $order->orderVariants()->createMany($orderVariants->toArray());

  session()->flash('success', 'Successfully checkout!');
});
  	// return redirect()->route('customer.orders.index');
	}
}
