<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\OrderStatusUpdated;
use App\Events\PendingOrdersNumber;
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
              // if status is cancelled before, and updated to paid
              if ($order->getOriginal('status') === 'cancelled' && ($request->status === 'delivered' || $request->status === 'shipped' || $request->status === 'pending')) {
                  // set order variants stock
                  $order->orderVariants()->each(function ($orderVariant) {
                      $orderVariant->variant->decrement('stock', $orderVariant->quantity);
                  });
              }

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
              ]);

              // set order variants status
              $order->orderVariants()->update(['status' => $request->status]);

              // if status is cancelled
              if ($request->status === 'cancelled') {
                  // set order variants stock
                  $order->orderVariants()->each(function ($orderVariant) {
                      $orderVariant->variant->increment('stock', $orderVariant->quantity);
                  });
              }

              broadcast(new OrderStatusUpdated($order));
              broadcast(new PendingOrdersNumber());
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
