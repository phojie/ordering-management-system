<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Services\FlashNotification;
use App\Services\RoleService;
use Gate;
use Illuminate\Http\Request;

class RoleController
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('role-list'), 404);

        // set query
        $query = (new RoleService())->get($request);

        // set pagination
        $roles = $query->paginate($request->rows ?? config('jie.per_page'))->appends($request->all());

        // set resource
        $query = RoleResource::collection($roles);

        return inertia('Admin/Roles/Index', [
            'roles' => $query,
        ]);
    }

    public function store(RoleRequest $request)
    {
        Gate::authorize('role-create');

        (new RoleService())->store($request);

        (new FlashNotification())->create($request->name);

        return redirect()->back();
    }

    public function show($id)
    {
    }

    public function update(RoleRequest $request, Role $role)
    {
        Gate::authorize('role-update');

        (new RoleService())->update($request, $role);

        (new FlashNotification())->update($request->name);

        return redirect()->back();
    }

    public function destroy(Role $role)
    {
        Gate::authorize('role-delete');

        (new RoleService())->delete($role->id);

        (new FlashNotification())->destroy($role->name, [
            [
                'url' => route('admin.roles.restore', $role->id),
                'method' => 'put',
            ],
        ]);

        return redirect()->back();
    }

    public function destroyMultiple(Request $request)
    {
        Gate::authorize('role-delete');

        (new RoleService())->deleteMultiple($request->ids);

        (new FlashNotification())->destroy(count($request->ids).' roles', [
            [
                'url' => route('admin.roles.restore-multiple'),
                'method' => 'put',
                'data' => [
                    'ids' => $request->ids,
                ],
            ],
        ]);

        return redirect()->back();
    }

    public function restore(Role $role)
    {
        Gate::authorize('role-delete');

        (new RoleService())->restore($role->id);

        (new FlashNotification())->restore($role->name, [
            [
                'url' => route('admin.roles.destroy', $role->id),
                'method' => 'delete',
            ],
        ]);

        return redirect()->back();
    }

    public function restoreMultiple(Request $request)
    {
        Gate::authorize('role-delete');

        (new RoleService())->retoreMultiple($request->ids);

        (new FlashNotification())->restore(count($request->ids).' roles', [
            [
                'url' => route('admin.roles.destroy-multiple'),
                'method' => 'delete',
                'data' => [
                    'ids' => $request->ids,
                ],
            ],
        ]);

        return redirect()->back();
    }
}
