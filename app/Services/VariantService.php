<?php

namespace App\Services;

use App\Models\Item;
use App\Services\Interfaces\VariantServiceInterface;

class VariantService implements VariantServiceInterface
{
	public function storeMultiple(object $request, Item $item): void
	{
		try {
			$variants = collect($request->variants)
					->filter(function ($variant) {
						return $variant['name'];
					})
					->map(function ($variant) {
						return [
							'name' => $variant['name'],
							'price' => $variant['price'],
							'stock' => $variant['stock'],
						];
					})
					->toArray();
			$item->variants()->createMany($variants);
		} catch (\Exception $e) {
			throw $e;
		}
	}

  public function updateMultiple(object $request, Item $item): void
  {
  	try {
  		$variants = collect($request->variants)
  		  ->filter(function ($variant) {
  		  	return $variant['name'];
  		  })
  		  ->map(function ($variant) use ($item) {
  		  	return [
  		  		'id' => \Str::of($variant['id'])->isUuid() ? $variant['id'] : null,
  		  		'item_id' => $item->id,
  		  		'name' => $variant['name'],
  		  		'price' => $variant['price'],
  		  		'stock' => $variant['stock']
  		  	];
  		  })
        // $item->variants()->upsert($variants, ['id'], ['name', 'price', 'stock']);
  		  ->each(function ($variant) use ($item) {
  		  	$item->variants()->updateOrCreate(['id' => $variant['id']], $variant);
  		  });

  		$item->variants()->whereNotIn('id', collect($variants)->pluck('id'))->delete();
  	} catch (\Exception $e) {
  		throw $e;
  	}
  }
}