<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
  public function creating(Category $category): void
	{
    // set slug
    $category->slug = \Str::slug($category->name);
	}
}
