<?php

namespace App\Services;

use App\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;

class RoleService
{
	public function get($request)
	{
		try {
			// set model
			$model = Role::query()
			  ->withTrashed()
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

   public function store($request)
   {
   	try {
   		Role::create([
   			'name' => $request->name,
   			'description' => $request->description,
   			'color' => $request->color,
   			'guard_name' => 'web',
   		]);
   	} catch (\Exception $e) {
   		(new FlashNotification())->error($e->getMessage());
   	}
   }

   public function update($request, $role)
   {
   	try {
   		$role->update([
   			'name' => $request->name,
   			'description' => $request->description,
   			'color' => $request->color,
   			'guard_name' => 'web',
   		]);
   	} catch (\Exception $e) {
   		(new FlashNotification())->error($e->getMessage());
   	}
   }

   public function destroy($role)
   {
     try {
       $role->delete();
     } catch (\Exception $e) {
       (new FlashNotification())->error($e->getMessage());
     }
   }

  public function destroyMultiple($ids)
  {
  	try {
  		\DB::transaction(function () use ($ids) {
  			Role::whereIn('id', $ids)->get()->each->delete();
  		});
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function restore($role)
  {
  	try {
  		$role->restore();
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }


  public function retoreMultiple($ids)
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
