<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Inertia\Inertia;

class PublicController
{
    public function index()
    {
        $randomCategories = Category::query()
            ->inRandomOrder()
            ->limit(3)
            ->get();

        $trendingProducts = Product::query()
                ->inRandomOrder()
        ->with('variants', fn ($query) => $query->where('stock', '>', 0))
                ->limit(4)
                ->get();

        return Inertia::render('Index', [
            'categories' => CategoryResource::collection($randomCategories),
            'products' => ProductResource::collection($trendingProducts),
        ]);
    }
}
