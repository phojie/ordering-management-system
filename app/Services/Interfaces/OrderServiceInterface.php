<?php

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
}
