<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Models\Product;

interface VariantServiceInterface
{
    public function storeMultiple(object $request, Product $product): void;

    public function updateMultiple(object $request, Product $product): void;
}
