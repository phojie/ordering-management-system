<?php

namespace App\Http\Controllers\Customer;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Inertia\Inertia;

class ProductController
{
  public function index()
  {
    $products = Product::get();

    return Inertia::render('Customer/Product/Index', [
      'products' => ProductResource::collection($products),
    ]);
  }

	public function show(string $slug)
	{
		$category = Product::where('slug', $slug)->firstOrFail();

		// return new ProductResource($category);
    return Inertia::render('Customer/Product/Show', [
      'product' => new ProductResource($category),
    ]);
	}
}
