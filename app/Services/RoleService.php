<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Services\Interfaces\RoleServiceInterface;
use Spatie\QueryBuilder\QueryBuilder;

class RoleService implements RoleServiceInterface
{
    public function get(object $request): QueryBuilder
    {
        try {
            // set model
            $model = Role::query()
              ->withTrashed()
                ->withCount('permissions')
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

   public function store(RoleRequest $request): void
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
           throw $e;
       }
   }

   public function update(RoleRequest $request, Role $role): void
   {
       try {
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
           throw $e;
       }
   }

   public function delete(string $id): void
   {
       try {
           Role::findOrFail($id)->delete();
       } catch (\Exception $e) {
           throw $e;
       }
   }

  public function deleteMultiple(array $ids): void
  {
      try {
          \DB::transaction(function () use ($ids) {
              Role::whereIn('id', $ids)->get()->each->delete();
          });
      } catch (\Exception $e) {
          throw $e;
      }
  }

  public function restore(string $id): void
  {
      try {
          Role::onlyTrashed()->findOrFail($id)->restore();
      } catch (\Exception $e) {
          throw $e;
      }
  }

  public function retoreMultiple(array $ids): void
  {
      try {
          \DB::transaction(function () use ($ids) {
              Role::onlyTrashed()->whereIn('id', $ids)->get()->each->restore();
          });
      } catch (\Exception $e) {
          throw $e;
      }
  }
}
