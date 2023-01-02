<?php

namespace App\Http\Controllers\Customer;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController
{
	public function index(Request $request)
	{
		// TODO: Add pagination
		$products = Product::query()
				->with(['variants', 'categories'])
				->search($request->search)
				->get();

		return Inertia::render('Customer/Products/Index', [
			'products' => ProductResource::collection($products),
		]);
	}

	public function show(string $slug)
	{
		$product = Product::query()
			->with(['variants', 'categories'])
		  ->where('slug', $slug)->firstOrFail();

		// return new ProductResource($category);
		return Inertia::render('Customer/Products/Show', [
			'product' => new ProductResource($product),
		]);
	}
}
