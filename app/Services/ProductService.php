<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;
use Spatie\QueryBuilder\QueryBuilder;

class ProductService implements ProductServiceInterface
{
    public function get(object $request): QueryBuilder
    {
        try {
            // set model
            $model = Product::query()
                ->withTrashed()
                ->with(['variants', 'categories'])
                ->search($request->search);

            // set query builder
            $query = QueryBuilder::for($model)
              ->defaultSort('-created_at')
              ->allowedSorts(['name', 'status', 'description', 'created_at'])
              ->allowedFilters(['name', 'status', 'description']);

            return $query;
        } catch (\Exception $e) {
            throw $e;
        }
    }

   public function store(ProductRequest $request): void
   {
       try {
           \DB::transaction(function () use ($request) {
               $product = Product::create(
                   [
                       'name' => $request->name,
                       'description' => $request->description,
                       'status' => $request->status,
                   ]
               );

               $categoriesIds = collect($request->categories)->pluck('id')->toArray();
               $product->categories()->attach($categoriesIds);

               // if has request variants
               if ($request->variants) {
                   (new VariantService())->storeMultiple($request, $product);
               }

               // if has request image
               if ($request->image) {
                   (new FileUploaderService())->uploadProductImageToMedia($product->id, $request->image);
               }
           });
       } catch (\Exception $e) {
           throw $e;
       }
   }

   public function update(ProductRequest $request, Product $product): void
   {
       try {
           \DB::transaction(function () use ($request, $product) {
               $product->update([
                   'name' => $request->name,
                   'description' => $request->description,
                   'status' => $request->status,
               ]);

               $categoriesIds = collect($request->categories)->pluck('id')->toArray();
               $product->categories()->sync($categoriesIds);

               // if has request variants
               if ($request->variants) {
                   (new VariantService())->updateMultiple($request, $product);
               }

               // if has request image
               if ($request->image) {
                   (new FileUploaderService())->uploadProductImageToMedia($product->id, $request->image);
               } else {
                   (new FileUploaderService())->deleteProductImageFromMedia($product->id);
               }
           });
       } catch (\Exception $e) {
           throw $e;
       }
   }

   public function delete(string $id): void
   {
       try {
           Product::findOrFail($id)->delete();
       } catch (\Exception $e) {
           throw $e;
       }
   }

  public function deleteMultiple(array $ids): void
  {
      try {
          \DB::transaction(function () use ($ids) {
              Product::whereIn('id', $ids)->get()->each->delete();
          });
      } catch (\Exception $e) {
          throw $e;
      }
  }

  public function restore(string $id): void
  {
      try {
          Product::onlyTrashed()->findOrFail($id)->restore();
      } catch (\Exception $e) {
          throw $e;
      }
  }

  public function retoreMultiple(array $ids): void
  {
      try {
          \DB::transaction(function () use ($ids) {
              Product::onlyTrashed()->whereIn('id', $ids)->get()->each->restore();
          });
      } catch (\Exception $e) {
          throw $e;
      }
  }
}
