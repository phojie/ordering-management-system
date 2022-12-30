<?php

namespace App\Http\Controllers\Components;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController
{
	public function index()
	{
		$query = Product::get();

		return response()->json($query, 200);
	}

	public function show($id)
	{
		$query = Product::query()
			  ->with(['variants', 'categories'])
			  ->find($id);

		$product = new ProductResource($query);

		return response()->json($product, 200);
	}
}
