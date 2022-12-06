<?php

namespace App\Services;

use App\Models\Item;
use App\Services\Interfaces\ItemServiceInterface;
use Spatie\QueryBuilder\QueryBuilder;

class ItemService implements ItemServiceInterface
{
	public function get(object $request): QueryBuilder
	{
		try {
			// set model
			$model = Item::query()
				->withTrashed()
				->with(['variants'])
				->search($request->search);

			// set query builder
			$query = QueryBuilder::for($model)
			  ->defaultSort('-created_at')
			  ->allowedSorts(['name', 'status', 'description', 'created_at'])
			  ->allowedFilters(['name', 'status', 'description']);

			return $query;
		} catch (\Exception $e) {
			abort(500, $e->getMessage());
		}
	}

   public function store(object $request): void
   {
   	try {
   		\DB::transaction(function () use ($request) {
   			$item = Item::create(
   				[
   					'name' => $request->name,
   					'description' => $request->description,
   					'status' => $request->status,
   				]
   			);

   			// if has request variants
   			if ($request->variants) {
   				(new VariantService())->storeMultiple($request, $item);
   			}
   		});
   	} catch (\Exception $e) {
   		abort(500, $e->getMessage());
   	}
   }

   public function update(object $request, string $id): void
   {
   	try {
   		$item = Item::findOrFail($id);
   		// \DB::transaction(function () use ($request, $item) {
   			$item->update([
   				'name' => $request->name,
   				'description' => $request->description,
   				'status' => $request->status,
   			]);

   			// if has request variants
   			if ($request->variants) {
   				(new VariantService())->updateMultiple($request, $item);
   			}
   		// });
   	} catch (\Exception $e) {
   		abort(500, $e->getMessage());
   	}
   }

   public function delete(string $id): void
   {
   	try {
   		Item::findOrFail($id)->delete();
   	} catch (\Exception $e) {
   		abort(500, $e->getMessage());
   	}
   }

  public function deleteMultiple(array $ids): void
  {
  	try {
  		\DB::transaction(function () use ($ids) {
  			Item::whereIn('id', $ids)->get()->each->delete();
  		});
  	} catch (\Exception $e) {
  		abort(500, $e->getMessage());
  	}
  }

  public function restore(string $id): void
  {
  	try {
  		Item::onlyTrashed()->findOrFail($id)->restore();
  	} catch (\Exception $e) {
  		abort(500, $e->getMessage());
  	}
  }

  public function retoreMultiple(array $ids): void
  {
  	try {
  		\DB::transaction(function () use ($ids) {
  			Item::onlyTrashed()->whereIn('id', $ids)->get()->each->restore();
  		});
  	} catch (\Exception $e) {
  		abort(500, $e->getMessage());
  	}
  }
}
