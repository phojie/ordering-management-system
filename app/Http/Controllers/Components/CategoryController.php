<?php

namespace App\Http\Controllers\Components;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController
{
	public function show($id)
	{
		$query = Category::query()
				->find($id);
		$category = new CategoryResource($query);

		return response()->json($category, 200);
	}
}
