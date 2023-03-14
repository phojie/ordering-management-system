<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

interface CategoryServiceInterface
{
    public function get(object $request): object;

    public function store(CategoryRequest $request): void;

    public function update(CategoryRequest $request, Category $category): void;

    public function delete(string $id): void;

    public function deleteMultiple(array $ids): void;

    public function restore(string $id): void;

    public function retoreMultiple(array $ids): void;
}
