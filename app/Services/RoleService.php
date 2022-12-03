<?php

namespace App\Services;

use App\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;

class RoleService
{
	public function get(object $request)
	{
		try {
			// set model
			$model = Role::query()
			  ->withTrashed()
				->withCount('permissions')
			  ->search($request->search);

			// set query builder
			$query = QueryBuilder::for($model)
			  ->defaultSort('created_at')
			  ->allowedSorts(['name', 'description', 'created_at'])
			  ->allowedFilters(['name', 'description']);

			return $query;
		} catch (\Exception $e) {
			(new FlashNotification())->error($e->getMessage());
		}
	}

   public function store(object $request): void
   {
   	try {
   		\DB::transaction(function () use ($request) {
   			$permissions = collect($request->permissions)->pluck('name');

   			$role = Role::make(
   				[
   					'name' => $request->name,
   					'description' => $request->description,
   					'guard_name' => 'web',
   				]
   			);

   			$role->givePermissionTo($permissions);
   			$role->saveOrFail();
   		});
   	} catch (\Exception $e) {
   		(new FlashNotification())->error($e->getMessage());
   	}
   }

   public function update(object $request, string $id): void
   {
   	try {
      $role = Role::findOrFail($id);
   		\DB::transaction(
   			function () use ($request, $role) {
   				$permissions = collect($request->permissions)->pluck('name');

   				$role->update([
   					'name' => $request->name,
   					'description' => $request->description,
   				]);

   				$role->syncPermissions($permissions);
   			}
   		);
   	} catch (\Exception $e) {
   		(new FlashNotification())->error($e->getMessage());
   	}
   }

   public function delete(string $id): void
   {
   	try {
      Role::findOrFail($id)->delete();
   	} catch (\Exception $e) {
   		(new FlashNotification())->error($e->getMessage());
   	}
   }

  public function deleteMultiple(array $ids): void
  {
  	try {
  		\DB::transaction(function () use ($ids) {
  			Role::whereIn('id', $ids)->get()->each->delete();
  		});
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function restore(string $id): void
  {
  	try {
      Role::onlyTrashed()->findOrFail($id)->restore();
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function retoreMultiple(array $ids): void
  {
  	try {
  		\DB::transaction(function () use ($ids) {
  			Role::onlyTrashed()->whereIn('id', $ids)->get()->each->restore();
  		});
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }
}
