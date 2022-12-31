<?php

namespace App\Http\Controllers\Customer;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController
{
	public function show(string $slug)
	{
		$category = Product::where('slug', $slug)->firstOrFail();

		return new ProductResource($category);
	}
}
