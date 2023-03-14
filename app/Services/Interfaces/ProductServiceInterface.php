<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Http\Requests\ProductRequest;
use App\Models\Product;

interface ProductServiceInterface
{
    public function get(object $request): object;

    public function store(ProductRequest $request): void;

    public function update(ProductRequest $request, Product $product): void;

    public function delete(string $id): void;

    public function deleteMultiple(array $ids): void;

    public function restore(string $id): void;

    public function retoreMultiple(array $ids): void;
}
