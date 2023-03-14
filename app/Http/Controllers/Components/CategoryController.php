<?php

declare(strict_types=1);

namespace App\Http\Controllers\Components;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

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
        ->with(['products'])
                ->find($id);
        $category = new CategoryResource($query);

        return response()->json($category, 200);
    }

  public function random(Request $request)
  {
      $limit = $request->limit ?? 3;

      $query = Category::query()
        ->inRandomOrder()
        ->limit($limit)
        ->get();

      return response()->json($query, 200);
  }
}
