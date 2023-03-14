<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Services\Interfaces\VariantServiceInterface;

class VariantService implements VariantServiceInterface
{
    public function storeMultiple(object $request, Product $product): void
    {
        try {
            $variants = collect($request->variants)
                    ->filter(function ($variant) {
                        return $variant['name'];
                    })
                    ->map(function ($variant) {
                        return [
                            'name' => $variant['name'],
                            'price' => $variant['price'],
                            'stock' => $variant['stock'],
                        ];
                    })
                    ->toArray();
            $product->variants()->createMany($variants);
        } catch (\Exception $e) {
            throw $e;
        }
    }

  public function updateMultiple(object $request, Product $product): void
  {
      try {
          $variants = collect($request->variants)
            ->filter(function ($variant) {
                return $variant['name'];
            })
            ->map(function ($variant) use ($product) {
                return [
                    'id' => \Str::of($variant['id'])->isUuid() ? $variant['id'] : null,
                    'product_id' => $product->id,
                    'name' => $variant['name'],
                    'price' => $variant['price'],
                    'stock' => $variant['stock'],
                ];
            })
          // $product->variants()->upsert($variants, ['id'], ['name', 'price', 'stock']);
            ->each(function ($variant) use ($product) {
                $product->variants()->updateOrCreate(['id' => $variant['id']], $variant);
            });

          $product->variants()->whereNotIn('id', collect($variants)->pluck('id'))->delete();
      } catch (\Exception $e) {
          throw $e;
      }
  }
}
