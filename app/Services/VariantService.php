<?php

namespace App\Services;

use App\Models\Item;
use App\Services\Interfaces\VariantServiceInterface;

class VariantService implements VariantServiceInterface
{
	public function storeMultiple(object $request, Item $item): void
	{
		try {
			$variants = collect($request->variants)->map(function ($variant) {
				return [
					'name' => $variant['name'],
					'price' => $variant['price'],
					'stock' => $variant['stock'],
				];
			})->toArray();
			$item->variants()->createMany($variants);
		} catch (\Exception $e) {
			(new FlashNotification())->error($e->getMessage());
		}
	}

  public function updateMultiple(object $request, Item $item): void
  {
  	try {
  		$variants = collect($request->variants)
  			  ->map(function ($variant) use ($item) {
  			  	return [
  			  		'id' => \Str::of($variant['id'])->isUuid() ? $variant['id'] : \Str::uuid(),
  			  		'item_id' => $item->id,
  			  		'name' => $variant['name'],
  			  		'price' => $variant['price'],
  			  		'stock' => $variant['stock'],
  			  	];
  			  })
  			  ->toArray();

  		$item->variants()->upsert($variants, ['id'], ['name', 'price', 'stock']);

  		$item->variants()->whereNotIn('id', collect($variants)->pluck('id'))->delete();
  	} catch (\Exception $e) {
  		abort(500, $e->getMessage());
  	}
  }
}
