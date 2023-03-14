<?php

declare(strict_types=1);

namespace App\Http\Controllers\Components;

use App\Models\Permission;

class PermissionController
{
    public function index()
    {
        // TODO implement searchable and pagination
        $query = Permission::get();

        return response()->json($query, 200);
    }
}
