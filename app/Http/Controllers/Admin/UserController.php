<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\FlashNotification;
use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Controller;

class UserController extends Controller
{
	public function index(Request $request)
	{
		abort_unless(\Gate::allows('user-list'), 404);

		// set query
		$query = (new UserService())->get($request);

		// set pagination
		$users = $query->paginate($request->rows ?? config('jie.per_page'))->appends($request->all());

		// set resource
		$query = UserResource::collection($users);

		return inertia('Admin/Users/Index', [
			'users' => $query,
		]);
	}

	public function store(UserRequest $request)
	{
		\Gate::authorize('user-create');

		(new UserService())->store($request);

		(new FlashNotification)->create($request->username);

		return redirect()->back();
	}

	public function show(User $user)
	{
		// get user
	}

  public function update(UserRequest $request, User $user)
  {
  	\Gate::authorize('user-update');

  	(new UserService())->update($request, $user);

  	(new FlashNotification)->update($request->username);

  	return redirect()->back();
  }

	public function destroy(User $user)
	{
		\Gate::authorize('user-delete');

		(new UserService())->delete($user->id);

		(new FlashNotification)->destroy($user->username, [
			[
				'url' => route('users.restore', $user->id),
				'method' => 'put',
			],
		]);

		return redirect()->back();
	}

	public function destroyMultiple(Request $request)
	{
		\Gate::authorize('user-delete');

		(new UserService())->deleteMultiple($request->ids);

		(new FlashNotification)->destroy(count($request->ids).' users', [
			[
				'url' => route('users.restore-multiple'),
				'method' => 'put',
				'data' => [
					'ids' => $request->ids,
				],
			],
		]);

		return redirect()->back();
	}

  public function restore(User $user)
  {
  	\Gate::authorize('user-delete');

  	(new UserService())->restore($user->id);

  	(new FlashNotification)->restore($user->username, [
  		[
  			'url' => route('users.destroy', $user->id),
  			'method' => 'delete',
  		],
  	]);

  	return redirect()->back();
  }

  public function restoreMultiple(Request $request)
  {
  	\Gate::authorize('user-delete');

  	(new UserService())->retoreMultiple($request->ids);

  	(new FlashNotification)->restore(count($request->ids).' users', [
  		[
  			'url' => route('users.destroy-multiple'),
  			'method' => 'delete',
  			'data' => [
  				'ids' => $request->ids,
  			],
  		],
  	]);

  	return redirect()->back();
  }
}
