<?php

namespace App\Http\Controllers\Customer;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController
{
	public function show(string $slug)
	{
		$category = Category::where('slug', $slug)->firstOrFail();

		return new CategoryResource($category);
	}
}
