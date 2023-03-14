<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Http\Requests\RoleRequest;
use App\Models\Role;

interface RoleServiceInterface
{
    public function get(object $request): object;

    public function store(RoleRequest $request): void;

    public function update(RoleRequest $request, Role $role): void;

    public function delete(string $id): void;

    public function deleteMultiple(array $ids): void;

    public function restore(string $id): void;

    public function retoreMultiple(array $ids): void;
}
