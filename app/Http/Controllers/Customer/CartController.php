<?php

namespace App\Http\Controllers\Customer;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Variant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController
{
	public function index(Request $request)
	{
		// TODO: Add pagination
		$carts = Cart::query()
						  ->where('user_id', $request->user()->id)
              ->with('variant', 'product')
						  ->get();

		return Inertia::render('Customer/Carts/Index', [
			'carts' => CartResource::collection($carts),
		]);
	}

  public function store(Request $request)
  {
  	$request->validate([
  		'variantId' => 'required|exists:variants,id',
  		'quantity' => 'required|integer|min:1',
  	]);

  	// $cart = Cart::query()
  	//   ->where('user_id', $request->user()->id)
  	//   ->where('variant_id', $request->input('variant_id'))
  	//   ->first();

  	// if ($cart) {
  	// 	$cart->quantity += $request->input('quantity');
  	// 	$cart->save();
  	// } else {
  	// 	$cart = Cart::create([
  	// 		'user_id' => $request->user()->id,
  	// 		'variant_id' => $request->input('variant_id'),
    //     'product_id' => $cart->product_id,
  	// 		'quantity' => $request->input('quantity'),
  	// 	]);
  	// }]

    $variant = Variant::findOrFail($request->variantId);

    // updateOrCreate
    Cart::updateOrCreate([
      'user_id' => $request->user()->id,
      'variant_id' => $variant->id,
      'product_id' => $variant->product_id,
    ], [
      'quantity' => $request->quantity,
    ]);

  	return redirect()->route('customer.carts.index');
  }
}
