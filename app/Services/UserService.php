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
		// TODO refactor this one, move when to scope
			  // ->when($request->search, fn ($q) => $q->search($request->search));
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

  // store
  public function store($userRequest)
  {
  	try {
  		$userRequest->validated();

  		$user = User::create([
  			'username' => $userRequest->username,
  			'email' => $userRequest->email,
  			'first_name' => $userRequest->firstName,
  			'last_name' => $userRequest->lastName,
  			'image_url' => $userRequest->imageUrl,
  			'password' => bcrypt($userRequest->password),
  		]);

  		$roles = collect($userRequest->roles)->pluck('name');
  		$user->assignRole($roles);
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function update($userRequest, $user)
  {
  	try {
  		$user->update([
  			'username' => $userRequest->username,
  			'email' => $userRequest->email,
  			'first_name' => $userRequest->firstName,
  			'last_name' => $userRequest->lastName,
  			'image_url' => $userRequest->imageUrl,
  		]);

  		$roles = collect($userRequest->roles)->pluck('name');
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
