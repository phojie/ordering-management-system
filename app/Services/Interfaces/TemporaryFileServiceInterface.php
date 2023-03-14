<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

interface TemporaryFileServiceInterface
{
    public function store(object $request): string;

    public function delete(string $folder): void;
}
