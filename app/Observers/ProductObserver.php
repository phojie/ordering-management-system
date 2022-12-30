<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
  public function creating(Product $product): void
	{
    $product->slug = \Str::slug($product->name);
	}

	public function deleted(Product $product): void
	{
		$product->status = 'deleted';
		$product->save();
	}

	public function restored(Product $product): void
	{
		$product->status = 'active';
		$product->save();
	}
}
