<?php

namespace App\Services\Interfaces;

use App\Http\Requests\ItemRequest;
use App\Models\Item;

interface ItemServiceInterface
{
	public function get(object $request): object;

	public function store(ItemRequest $request): void;

	public function update(ItemRequest $request, Item $item): void;

	public function delete(string $id): void;

	public function deleteMultiple(array $ids): void;

	public function restore(string $id): void;

	public function retoreMultiple(array $ids): void;
}
