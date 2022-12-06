<?php

namespace App\Services;

use App\Models\Category;
use App\Services\Interfaces\CategoryServiceInterface;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryService implements CategoryServiceInterface
{
	public function get(object $request): QueryBuilder
	{
		try {
			// set model
			$model = Category::query()
			  ->withTrashed()
            ->with(['items'])
            ->withCount('items')
			  ->search($request->search);

			// set query builder
			$query = QueryBuilder::for($model)
			  ->defaultSort('-created_at')
			  ->allowedSorts(['name', 'description', 'created_at'])
			  ->allowedFilters(['name', 'description']);

			return $query;
		} catch (\Exception $e) {
			throw $e;
		}
	}

   public function store(object $request): void
   {
   	try {
   		\DB::transaction(function () use ($request) {
   			$category = Category::create(
   				[
   					'name' => $request->name,
   					'description' => $request->description,
   				]
   			);

   			$itemsIds = collect($request->items)->pluck('id')->toArray();
   			$category->items()->attach($itemsIds);
   		});
   	} catch (\Exception $e) {
   		throw $e;
   	}
   }

   public function update(object $request, string $id): void
   {
   	try {
   		$category = Category::findOrFail($id);
   		\DB::transaction(function () use ($request, $category) {
   			$category->update([
   				'name' => $request->name,
   				'description' => $request->description,
   			]);

   			$itemsIds = collect($request->items)->pluck('id')->toArray();
   			$category->items()->sync($itemsIds);
   		});
   	} catch (\Exception $e) {
   		throw $e;
   	}
   }

   public function delete(string $id): void
   {
   	try {
   		Category::findOrFail($id)->delete();
   	} catch (\Exception $e) {
   		throw $e;
   	}
   }

  public function deleteMultiple(array $ids): void
  {
  	try {
  		\DB::transaction(function () use ($ids) {
  			Category::whereIn('id', $ids)->get()->each->delete();
  		});
  	} catch (\Exception $e) {
  		throw $e;
  	}
  }

  public function restore(string $id): void
  {
  	try {
  		Category::onlyTrashed()->findOrFail($id)->restore();
  	} catch (\Exception $e) {
  		throw $e;
  	}
  }

  public function retoreMultiple(array $ids): void
  {
  	try {
  		\DB::transaction(function () use ($ids) {
  			Category::onlyTrashed()->whereIn('id', $ids)->get()->each->restore();
  		});
  	} catch (\Exception $e) {
  		throw $e;
  	}
  }
}
