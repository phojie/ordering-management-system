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
}
