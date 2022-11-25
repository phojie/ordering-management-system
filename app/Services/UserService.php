<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Services\CustomSorts\CustomRoleSort;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class UserService
{
	public function get($request)
	{
		try {
			// set model
			$model = User::query()
			  ->withTrashed()
			  ->whereNotIn('id', [auth()->user()->id])
			  ->with(['roles'])
				->search($request->search);

			// set query builder
			$query = QueryBuilder::for($model)
				->defaultSort('created_at')
				->allowedSorts([
					'username', 'full_name', 'status', 'created_at',
					AllowedSort::custom('roles.name', new CustomRoleSort, 'name'),
				])
				->allowedFilters(['username', 'full_name', 'status', 'roles.name']);

			return $query;
		} catch (\Exception $e) {
			(new FlashNotification())->error($e->getMessage());
		}
	}

  public function show(User $user)
  {
  	// get user
  }

  public function store($request)
  {
  	try {
  		$user = User::create([
  			'username' => $request->username,
  			'email' => $request->email,
  			'first_name' => $request->firstName,
  			'last_name' => $request->lastName,
  			'image_url' => $request->imageUrl,
  			'password' => bcrypt($request->password),
  		]);

  		$roles = collect($request->roles)->pluck('name');
  		$user->assignRole($roles);
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function update($request, $user)
  {
  	try {
  		$user->update([
  			'username' => $request->username,
  			'email' => $request->email,
  			'first_name' => $request->firstName,
  			'last_name' => $request->lastName,
  			'image_url' => $request->imageUrl,
  		]);

  		$roles = collect($request->roles)->pluck('name');
  		$user->syncRoles($roles);
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function destroy($user)
  {
  	try {
  		$user->delete();
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function destroyMultiple($ids)
  {
  	try {
  		\DB::transaction(function () use ($ids) {
  			User::whereIn('id', $ids)->get()->each->delete();
  		});
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function restore($user)
  {
  	try {
  		$user->restore();
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function retoreMultiple($ids)
  {
  	try {
  		\DB::transaction(function () use ($ids) {
  			User::onlyTrashed()->whereIn('id', $ids)->get()->each->restore();
  		});
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function forceDelete($user)
  {
  }
}
