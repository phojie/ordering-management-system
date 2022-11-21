<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\CustomSort\CustomRoleSort;
use App\Services\FlashNotification;
use Illuminate\Http\Request;
use Inertia\Controller;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
	public function index(Request $request)
	{
		// set model
		$model = User::query()
		  ->withTrashed()
		  // ->whereNotIn('id', [auth()->user()->id])
		  ->with(['roles'])
		  ->when($request->search, fn ($q) => $q->search($request->search));

		// set query builder
		$query = QueryBuilder::for($model)
			->defaultSort('created_at')
			->allowedSorts([
				'full_name', 'status','created_at',
				AllowedSort::custom('roles.name', new CustomRoleSort, 'name'),
			])
			->allowedFilters(['full_name', 'status', 'roles.name']);

		// set pagination
		$users = $query->paginate(config('jie.per_page'))->appends($request->all());

		// set resource
		$query = UserResource::collection($users);

		return inertia('Admin/Users/Index', [
			'users' => $query,
			'search' => $request->search,
		]);
	}

	public function store(UserRequest $userRequest)
	{
		$userRequest->validated();

		User::create([
			'username' => $userRequest->username,
			'email' => $userRequest->email,
			'first_name' => $userRequest->firstName,
			'last_name' => $userRequest->lastName,
			'image_url' => $userRequest->imageUrl,
			'password' => bcrypt($userRequest->password),
		]);

		(new FlashNotification)->create($userRequest->username);

		return redirect()->back();
	}

	public function show(User $user)
	{
		// get user
	}

  public function update(UserRequest $userRequest, User $user)
  {
  	$userRequest->validated();

  	$user->update([
  		'username' => $userRequest->username,
  		'email' => $userRequest->email,
  		'first_name' => $userRequest->firstName,
  		'last_name' => $userRequest->lastName,
  		'image_url' => $userRequest->imageUrl,
  		'password' => bcrypt($userRequest->password),
  	]);

  	(new FlashNotification)->update($userRequest->username);

  	return redirect()->back();
  }

	public function destroy(User $user)
	{
		$user->delete();

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
		\DB::transaction(function () use ($request) {
			User::whereIn('id', $request->ids)->get()->each->delete();
		});

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
  	$user->restore();

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
  	// db transaction
  	\DB::transaction(function () use ($request) {
  		User::withTrashed()->whereIn('id', $request->ids)->get()->each->restore();
  	});

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
