<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function creating(Category $category): void
    {
        $category->slug = \Str::slug($category->name);
    }
}
