<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Http\Requests\UserRequest;
use App\Models\User;

interface UserServiceInterface
{
    public function get(object $request): object;

    public function show(string $id): object;

    public function store(UserRequest $request): void;

    public function update(UserRequest $request, User $user): void;

    public function delete(string $id): void;

    public function deleteMultiple(array $ids): void;

    public function restore(string $id): void;

    public function restoreMultiple(array $ids): void;

    public function changePassword(string $newPassword, User $user): void;
}
