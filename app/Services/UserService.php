<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\CustomSortsService\CustomRoleSort;
use App\Services\Interfaces\UserServiceInterface;
use DB;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class UserService implements UserServiceInterface
{
    public function get(object $request): QueryBuilder
    {
        // set model
        $model = User::query()
            ->withTrashed()
            ->whereNotIn('id', [auth()->user()->id])
            ->with(['roles'])
            ->search($request->search);

        // set query builder
        $query = QueryBuilder::for($model)
            ->defaultSort('-created_at')
            ->allowedSorts([
                'username', 'full_name', 'status', 'created_at',
                AllowedSort::custom('roles.name', new CustomRoleSort(), 'name'),
            ])
            ->allowedFilters(['username', 'full_name', 'status', 'roles.name']);

        return $query;
    }

  public function show(string $id): UserResource
  {
      // set query
      $query = User::query()
      ->withTrashed()
      ->with(['roles'])
      ->findOrFail($id);

      // set resource
      $user = new UserResource($query);

      return $user;
  }

  public function store(object $request): void
  {
      $user = User::create([
          'username' => $request->username,
          'email' => $request->email,
          'phone' => $request->phone,
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

      // if it has request address1
      if ($request->address1) {
          $user->address()->create([
              'address1' => $request->address1,
              'address2' => $request->address2,
              'city' => $request->city,
              'province' => $request->province,
              'postal_code' => $request->postalCode,
              'country' => 'Philippines',
              'user_id' => $user->id,
          ]);
      }
  }

  public function update(UserRequest $request, User $user): void
  {
      DB::transaction(function () use ($request, $user) {
          $user->update([
              'username' => $request->username,
              'email' => $request->email,
              'phone' => $request->phone,
              'first_name' => $request->firstName,
              'middle_name' => $request->middleName,
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
          } else {
              (new FileUploaderService())->deleteUserAvatarFromMedia($user->id);
          }

          // if has request address1
          if ($request->address1) {
              $user->address()->updateOrCreate(
                  ['user_id' => $user->id],
                  [
                      'address1' => $request->address1,
                      'address2' => $request->address2,
                      'city' => $request->city,
                      'province' => $request->province,
                      'postal_code' => $request->postalCode,
                      'country' => 'Philippines',
                      'user_id' => $user->id,
                  ]
              );
          }
      });
  }

  public function delete(string $id): void
  {
      User::findOrFail($id)->delete();
  }

  public function deleteMultiple(array $ids): void
  {
      DB::transaction(function () use ($ids) {
          User::whereIn('id', $ids)->get()->each->delete();
      });
  }

  public function restore(string $id): void
  {
      User::onlyTrashed()->findOrFail($id)->restore();
  }

  public function restoreMultiple(array $ids): void
  {
      DB::transaction(function () use ($ids) {
          User::onlyTrashed()->whereIn('id', $ids)->get()->each->restore();
      });
  }

  public function changePassword(string $newPassword, User $user): void
  {
      $user->update([
          'password' => bcrypt($newPassword),
      ]);
  }
}
