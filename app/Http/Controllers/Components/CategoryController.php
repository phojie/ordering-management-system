<?php

namespace App\Http\Controllers\Components;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController
{
	public function index()
	{
		$query = Category::get();

		return response()->json($query, 200);
	}

	public function show($id)
	{
		$query = Category::query()
        ->with(['items'])
				->find($id);
		$category = new CategoryResource($query);

		return response()->json($category, 200);
	}
}
