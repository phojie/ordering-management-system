<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\CustomSorts\CustomRoleSort;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class UserService
{
	public function get(object $request): QueryBuilder
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

  public function show(string $id): UserResource
  {
  	try {
  		// set query
  		$query = User::query()
  		->withTrashed()
  		->with(['roles'])
  		->findOrFail($id);

  		// set resource
  		$user = new UserResource($query);

  		return $user;
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function store(object $request): void
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

  		// if has request roles
  		if ($request->roles) {
  			$roles = collect($request->roles)->pluck('name');
  			$user->assignRole($roles);
  		}

  		// if has request avatar
  		if ($request->avatar) {
  			(new FileUploaderService())->uploadUserAvatarToMedia($user->id, $request->avatar);
  		}
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function update(object $request, string $id): void
  {
  	try {
  		$user = User::findOrFail($id);
  		\DB::transaction(function () use ($request, $user) {
  			$user->update([
  				'username' => $request->username,
  				'email' => $request->email,
  				'first_name' => $request->firstName,
  				'last_name' => $request->lastName,
  			]);

  			// if has request roles
  			if ($request->roles) {
  				$roles = collect($request->roles)->pluck('name');
  				$user->syncRoles($roles);
  			}

  			// if has request avatar
  			if ($request->avatar) {
  				(new FileUploaderService())->uploadUserAvatarToMedia($user->id, $request->avatar);
  			}
  		});
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function delete(string $id): void
  {
  	try {
  		User::findOrFail($id)->delete();
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function deleteMultiple(array $ids): void
  {
  	try {
  		\DB::transaction(function () use ($ids) {
  			User::whereIn('id', $ids)->get()->each->delete();
  		});
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function restore(string $id): void
  {
  	try {
  		User::onlyTrashed()->findOrFail($id)->restore();
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function retoreMultiple(array $ids): void
  {
  	try {
  		\DB::transaction(function () use ($ids) {
  			User::onlyTrashed()->whereIn('id', $ids)->get()->each->restore();
  		});
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }

  public function changePassword(string $newPassword, string $id): void
  {
  	try {
  		$user = User::findOrFail($id);
  		$user->update([
  			'password' => bcrypt($newPassword),
  		]);
  	} catch (\Exception $e) {
  		(new FlashNotification())->error($e->getMessage());
  	}
  }
}
