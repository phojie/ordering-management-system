<?php

declare(strict_types=1);

namespace App\Http\Controllers\Components;

use App\Http\Resources\RoleResource;
use App\Models\Role;

class RoleController
{
    public function index()
    {
        // TODO implement searchable and pagination
        $query = Role::get();

        return response()->json($query, 200);
    }

  public function show($id)
  {
      $query = Role::query()
              ->with('permissions')
              ->find($id);
      $role = new RoleResource($query);

      return response()->json($role, 200);
  }
}
