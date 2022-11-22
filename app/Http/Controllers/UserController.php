<?php

declare(strict_types=1);

namespace App\Http\Controllers;

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

	public function store(UserRequest $userRequest)
	{
		(new UserService())->store($userRequest);

		(new FlashNotification)->create($userRequest->username);

		return redirect()->back();
	}

	public function show(User $user)
	{
		// get user
	}

  public function update(UserRequest $userRequest, User $user)
  {
  	(new UserService())->update($userRequest, $user);

  	(new FlashNotification)->update($userRequest->username);

  	return redirect()->back();
  }

	public function destroy(User $user)
	{
		(new UserService())->destroy($user);

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
		(new UserService())->destroyMultiple($request);

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
  	(new UserService())->restore($user);

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
