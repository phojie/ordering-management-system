<?php

namespace App\Http\Controllers\Customer;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Inertia\Inertia;

class ProductController
{
  public function index()
  {
    // TODO: Add pagination
    $products = Product::get();

    return Inertia::render('Customer/Products/Index', [
      'products' => ProductResource::collection($products),
    ]);
  }

	public function show(string $slug)
	{
		$product = Product::where('slug', $slug)->firstOrFail();

		// return new ProductResource($category);
    return Inertia::render('Customer/Products/Show', [
      'product' => new ProductResource($product),
    ]);
	}
}
