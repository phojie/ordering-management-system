<?php

namespace App\Services;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Services\Interfaces\OrderServiceInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class OrderService.
 */
class OrderService implements OrderServiceInterface
{
	public function get(object $request): QueryBuilder
	{
		try {
			// set model
			$model = Order::query()
			->with(['orderVariants', 'orderVariants.variant', 'orderVariants.product', 'user'])
			->search($request->search);

			// set query builder
			$query = QueryBuilder::for($model)
					  ->defaultSort('-created_at')
					  ->allowedSorts(['name', 'order_number', 'status', 'created_at'])
					  ->allowedFilters(['name', AllowedFilter::scope('order_number', 'filterOrderNumber'), 'status']);

			return $query;
		} catch (\Exception $e) {
			throw $e;
		}
	}

  public function find(string $id): ?Order
  {
  	try {
  		// set model
  		$model = Order::query()
  		->with(['orderVariants', 'orderVariants.variant', 'orderVariants.product', 'user'])
  		->findOrFail($id);

  		return $model;
  	} catch (\Exception $e) {
  		throw $e;
  	}
  }

  public function update(OrderRequest $request, Order $order): void
  {
  	try {
  		\DB::transaction(function () use ($request, $order) {
  			$order->update([
  				'name' => $request->name,
  				'email' => $request->email,
  				'phone' => $request->phone,
  				'address' => $request->address,
  				'city' => $request->city,
  				'province' => $request->province,
  				'postal_code' => $request->postalCode,
  				'status' => $request->status,

  				'total_amount' => $request->totalAmount,
  				'taxes_amount' => $request->taxesAmount,
  				'shipping_amount' => $request->shippingAmount,

  				'user_id' => $request->user()->id,
  			]);

  			// set order variants status
  			$order->orderVariants()->update(['status' => $request->status]);

  			// TODO
  		});
  	} catch (\Exception $e) {
  		throw $e;
  	}
  }

  public function delete(string $id): void
  {
  	try {
  		\DB::transaction(function () use ($id) {
  			Order::findOrFail($id)->delete();
  		});
  	} catch (\Exception $e) {
  		throw $e;
  	}
  }

  // delete multiple
  public function deleteMultiple(array $ids): void
  {
  	try {
  		\DB::transaction(function () use ($ids) {
  			Order::query()->whereIn('id', $ids)->delete();
  		});
  	} catch (\Exception $e) {
  		throw $e;
  	}
  }
}
