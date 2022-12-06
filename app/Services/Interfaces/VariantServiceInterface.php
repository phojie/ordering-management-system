<?php

namespace App\Services\Interfaces;

use App\Models\Item;

interface VariantServiceInterface
{
	public function storeMultiple(object $request, Item $item): void;
}
