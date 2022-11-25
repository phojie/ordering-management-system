<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Services\FlashNotification;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController
{
	public function index(Request $request)
	{
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
		(new RoleService())->store($request);

		(new FlashNotification())->create($request->name);

		return redirect()->back();
	}

	public function show($id)
	{
	}

	public function update(RoleRequest $request, Role $role)
	{
		(new RoleService())->update($request, $role);

		(new FlashNotification)->update($request->name);

		return redirect()->back();
	}

	public function destroy(Role $role)
	{
		(new RoleService())->destroy($role);

		(new FlashNotification)->destroy($role->name, [
			[
				'url' => route('roles.restore', $role->id),
				'method' => 'put',
			],
		]);

		return redirect()->back();
	}

  public function destroyMultiple(Request $request)
  {
  	(new RoleService())->destroyMultiple($request->ids);

  	(new FlashNotification)->destroy(count($request->ids).' roles', [
  		[
  			'url' => route('roles.restore-multiple'),
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
  	(new RoleService())->restore($role);

  	(new FlashNotification)->restore($role->name, [
  		[
  			'url' => route('roles.destroy', $role->id),
  			'method' => 'delete',
  		],
  	]);

  	return redirect()->back();
  }

  public function restoreMultiple(Request $request)
  {
  	(new RoleService())->retoreMultiple($request->ids);

  	(new FlashNotification)->restore(count($request->ids).' roles', [
  		[
  			'url' => route('roles.destroy-multiple'),
  			'method' => 'delete',
  			'data' => [
  				'ids' => $request->ids,
  			],
  		],
  	]);

  	return redirect()->back();
  }
}