<?php

namespace App\Services;

use App\Http\Requests\ItemRequest;
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

   public function store(ItemRequest $request): void
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

   			$categoriesIds = collect($request->categories)->pluck('id')->toArray();
   			$item->categories()->attach($categoriesIds);

   			// if has request variants
   			if ($request->variants) {
   				(new VariantService())->storeMultiple($request, $item);
   			}

   			// if has request image
   			if ($request->image) {
   				(new FileUploaderService())->uploadItemImageToMedia($item->id, $request->image);
   			}
   		});
   	} catch (\Exception $e) {
   		throw $e;
   	}
   }

   public function update(ItemRequest $request, Item $item): void
   {
   	try {
   		\DB::transaction(function () use ($request, $item) {
   			$item->update([
   				'name' => $request->name,
   				'description' => $request->description,
   				'status' => $request->status,
   			]);

   			$categoriesIds = collect($request->categories)->pluck('id')->toArray();
   			$item->categories()->sync($categoriesIds);

   			// if has request variants
   			if ($request->variants) {
   				(new VariantService())->updateMultiple($request, $item);
   			}

   			// if has request image
   			if ($request->image) {
   				(new FileUploaderService())->uploadItemImageToMedia($item->id, $request->image);
   			} else {
   				(new FileUploaderService())->deleteItemImageFromMedia($item->id);
   			}
   		});
   	} catch (\Exception $e) {
   		throw $e;
   	}
   }

   public function delete(string $id): void
   {
   	try {
   		Item::findOrFail($id)->delete();
   	} catch (\Exception $e) {
   		throw $e;
   	}
   }

  public function deleteMultiple(array $ids): void
  {
  	try {
  		\DB::transaction(function () use ($ids) {
  			Item::whereIn('id', $ids)->get()->each->delete();
  		});
  	} catch (\Exception $e) {
  		throw $e;
  	}
  }

  public function restore(string $id): void
  {
  	try {
  		Item::onlyTrashed()->findOrFail($id)->restore();
  	} catch (\Exception $e) {
  		throw $e;
  	}
  }

  public function retoreMultiple(array $ids): void
  {
  	try {
  		\DB::transaction(function () use ($ids) {
  			Item::onlyTrashed()->whereIn('id', $ids)->get()->each->restore();
  		});
  	} catch (\Exception $e) {
  		throw $e;
  	}
  }
}
