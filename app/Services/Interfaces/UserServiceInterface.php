<?php

namespace App\Services\Interfaces;

interface UserServiceInterface
{
	public function get(object $request): object;

	public function show(string $id): object;

	public function store(object $request): void;

	public function update(object $request, string $id): void;

	public function delete(string $id): void;

	public function deleteMultiple(array $ids): void;

	public function restore(string $id): void;

	public function retoreMultiple(array $ids): void;

	public function changePassword(string $newPassword, string $id): void;
}
