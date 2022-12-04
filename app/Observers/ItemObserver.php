<?php

namespace App\Observers;

use App\Models\Item;

class ItemObserver
{
  public function creating(Item $item): void
	{
    $item->slug = \Str::slug($item->name);
	}

	public function deleted(Item $item): void
	{
		$item->status = 'deleted';
		$item->save();
	}

	public function restored(Item $item): void
	{
		$item->status = 'active';
		$item->save();
	}
}
