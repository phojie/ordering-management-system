<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\CustomSortsService\CustomRoleSort;
use App\Services\Interfaces\UserServiceInterface;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class UserService implements UserServiceInterface
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
                ->defaultSort('-created_at')
                ->allowedSorts([
                    'username', 'full_name', 'status', 'created_at',
                    AllowedSort::custom('roles.name', new CustomRoleSort(), 'name'),
                ])
                ->allowedFilters(['username', 'full_name', 'status', 'roles.name']);

            return $query;
        } catch (\Exception $e) {
            throw $e;
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
          throw $e;
      }
  }

  public function store(object $request): void
  {
      try {
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

          // if has request address1
          if ($request->address1) {
              $user->address()->create([
                  'address1' => $request->address1,
                  'address2' => $request->address2,
                  'city' => $request->city,
                  'province' => $request->province,
                  'postal_code' => $request->postalCode,
                  'country' => $request->country,
                  'user_id' => $user->id,
                  'country' => 'Philippines',
              ]);
          }
      } catch (\Exception $e) {
          throw $e;
      }
  }

  public function update(UserRequest $request, User $user): void
  {
      try {
          \DB::transaction(function () use ($request, $user) {
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
                          'country' => $request->country,
                          'user_id' => $user->id,
                          'country' => 'Philippines',
                      ]
                  );
              }
          });
      } catch (\Exception $e) {
          throw $e;
      }
  }

  public function delete(string $id): void
  {
      try {
          User::findOrFail($id)->delete();
      } catch (\Exception $e) {
          throw $e;
      }
  }

  public function deleteMultiple(array $ids): void
  {
      try {
          \DB::transaction(function () use ($ids) {
              User::whereIn('id', $ids)->get()->each->delete();
          });
      } catch (\Exception $e) {
          throw $e;
      }
  }

  public function restore(string $id): void
  {
      try {
          User::onlyTrashed()->findOrFail($id)->restore();
      } catch (\Exception $e) {
          throw $e;
      }
  }

  public function retoreMultiple(array $ids): void
  {
      try {
          \DB::transaction(function () use ($ids) {
              User::onlyTrashed()->whereIn('id', $ids)->get()->each->restore();
          });
      } catch (\Exception $e) {
          throw $e;
      }
  }

  public function changePassword(string $newPassword, User $user): void
  {
      try {
          $user->update([
              'password' => bcrypt($newPassword),
          ]);
      } catch (\Exception $e) {
          throw $e;
      }
  }
}
