<?php

namespace App\Http\Controllers\Customer;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Variant;

class OrderController
{
	public function store(OrderRequest $request)
	{
		\DB::transaction(function () use ($request) {
      // create order
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

      // create order variants
			$order->orderVariants()->createMany($orderVariants->toArray());

      // remove user carts
      $request->user()->carts()->delete();

      // minus stock
      $orderVariants->each(function ($variant) {
        $productVariant = Variant::find($variant['variant_id']);
        $productVariant->stock = $productVariant->stock - $variant['quantity'];
        $productVariant->save();
      });

			session()->flash('success', 'Successfully checkout!');
		});
		// return redirect()->route('customer.orders.index');
	}
}
