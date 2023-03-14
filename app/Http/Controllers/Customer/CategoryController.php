<?php

declare(strict_types=1);

namespace App\Http\Controllers\Customer;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController
{
    public function index(Request $request)
    {
        // TODO: Add pagination
        $categories = Category::query()
            ->withCount(['products'])
                ->search($request->search)
                ->get();

        return Inertia::render('Customer/Categories/Index', [
            'categories' => CategoryResource::collection($categories),
        ]);
    }

    public function show(string $slug, Request $request)
    {
        $category = Category::query()
          ->with('products', function ($query) use ($request) {
              $query->with(['variants', 'categories'])
                  ->search($request->search);
          })
          ->where('slug', $slug)
          ->firstOrFail();

        // return new CategoryResource($category);
        return Inertia::render('Customer/Categories/Show', [
            'category' => new CategoryResource($category),
        ]);
    }
}
