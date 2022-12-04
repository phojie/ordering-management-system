<?php

namespace App\Services\Interfaces;

interface ItemServiceInterface
{
	public function get(object $request): object;

	public function store(object $request): void;

	public function update(object $request, string $id): void;

	public function delete(string $id): void;

	public function deleteMultiple(array $ids): void;

	public function restore(string $id): void;

	public function retoreMultiple(array $ids): void;
}
