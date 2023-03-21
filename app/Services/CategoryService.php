<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\Interfaces\CategoryServiceInterface;
use DB;
use Exception;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryService implements CategoryServiceInterface
{
    public function get(object $request): QueryBuilder
    {
        try {
            // set model
            $model = Category::query()
            ->withTrashed()
            ->with(['products'])
            ->withCount('products')
            ->search($request->search);

            // set query builder
            $query = QueryBuilder::for($model)
              ->defaultSort('-created_at')
              ->allowedSorts(['name', 'description', 'created_at'])
              ->allowedFilters(['name', 'description']);

            return $query;
        } catch (Exception $e) {
            throw $e;
        }
    }

   public function store(CategoryRequest $request): void
   {
       try {
           DB::transaction(function () use ($request) {
               $category = Category::create(
                   [
                       'name' => $request->name,
                       'description' => $request->description,
                   ]
               );

               $productsIds = collect($request->products)->pluck('id')->toArray();
               $category->products()->attach($productsIds);

               // if has request image
               if ($request->image) {
                   (new FileUploaderService())->uploadCategoryImageToMedia($category->id, $request->image);
               }
           });
       } catch (Exception $e) {
           throw $e;
       }
   }

   public function update(CategoryRequest $request, Category $category): void
   {
       try {
           DB::transaction(function () use ($request, $category) {
               $category->update([
                   'name' => $request->name,
                   'description' => $request->description,
               ]);

               $productsIds = collect($request->products)->pluck('id')->toArray();
               $category->products()->sync($productsIds);

               // if has request image
               if ($request->image) {
                   (new FileUploaderService())->uploadCategoryImageToMedia($category->id, $request->image);
               } else {
                   (new FileUploaderService())->deleteCategoryImageFromMedia($category->id);
               }
           });
       } catch (Exception $e) {
           throw $e;
       }
   }

   public function delete(string $id): void
   {
       try {
           Category::findOrFail($id)->delete();
       } catch (Exception $e) {
           throw $e;
       }
   }

  public function deleteMultiple(array $ids): void
  {
      try {
          DB::transaction(function () use ($ids) {
              Category::whereIn('id', $ids)->get()->each->delete();
          });
      } catch (Exception $e) {
          throw $e;
      }
  }

  public function restore(string $id): void
  {
      try {
          Category::onlyTrashed()->findOrFail($id)->restore();
      } catch (Exception $e) {
          throw $e;
      }
  }

  public function retoreMultiple(array $ids): void
  {
      DB::transaction(function () use ($ids) {
          Category::onlyTrashed()->whereIn('id', $ids)->get()->each->restore();
      });
  }
}
