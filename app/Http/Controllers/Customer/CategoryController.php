<?php

namespace App\Http\Controllers\Customer;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Inertia\Inertia;

class CategoryController
{
  public function index() {
    // TODO: Add pagination
    $categories = Category::get();

    return Inertia::render('Customer/Categories/Index', [
      'categories' => CategoryResource::collection($categories),
    ]);
  }

	public function show(string $slug)
	{
    $category = Category::where('slug', $slug)->firstOrFail();

		// return new CategoryResource($category);
    return Inertia::render('Customer/Categories/Show', [
      'categories' => new CategoryResource($category),
    ]);
	}
}
