<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Http\Requests\OrderRequest;
use App\Models\Order;

/**
 * Interface OrderServiceInterface.
 */
interface OrderServiceInterface
{
    public function get(object $request): object;

    public function find(string $id): ?object;

    public function update(OrderRequest $request, Order $order): void;

    public function delete(string $id): void;

    public function deleteMultiple(array $ids): void;
}
