<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
	public function index(Request $request)
	{
		// set model
		$model = User::query()
		  ->whereNotIn('id', [auth()->user()->id])
		  ->withTrashed();

		// set query builder
		$query = QueryBuilder::for($model)
		  ->defaultSort('created_at')
		  ->allowedSorts(['full_name', 'status']);

		// ->allowedFilters(['username', 'email', 'full_name']);

		// if request search
		if (! empty($request->search)) {
			$query->where(function ($q) use ($request) {
				$q->where('username', 'ilike', "%{$request->search}%")
				  ->orWhere('email', 'ilike', "%{$request->search}%")
				  ->orWhere('full_name', 'ilike', "%{$request->search}%");
			});
		}

		// set pagination
		$users = $query->paginate(15)->appends($request->all());

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

		return redirect()->back()->with('notification', [
			'variant' => 'success',
			'title' => 'Successfully saved!',
			'message' => $userRequest->username.' has been created.',
		]);
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

  	return redirect()->back()->with('notification', [
  		'variant' => 'success',
  		'title' => 'Successfully saved!',
  		'message' => $userRequest->username.' has been updated.',
  	]);
  }

	public function destroy(User $user)
	{
		$user->delete();

		return redirect()->back()->with('notification', [
			'variant' => 'danger',
			'icon' => 'trash',
			'title' => 'Successfully deleted!',
			'message' => $user->username.' has been deleted.',
      'actions' => [
        [
          'label' => 'Undo',
          'url' => route('users.restore', $user->id),
          'method' => 'put',
        ],
      ],
		]);
	}

	public function destroyMultiple(Request $request)
	{
		\DB::transaction(function () use ($request) {
			User::whereIn('id', $request->ids)->get()->each->delete();
		});

		return redirect()->back()->with('notification', [
			'variant' => 'danger',
			'icon' => 'trash',
			'title' => 'Successfully deleted!',
			'message' => count($request->ids).' users deleted.',
      'actions' => [
        [
          'label' => 'Undo',
          'url' => route('users.restore-multiple'),
          'method' => 'put',
          'data' => [
            'ids' => $request->ids,
          ],
        ],
      ],

		]);
	}

  public function restore(User $user)
  {
  	$user->restore();

  	return redirect()->back()->with('notification', [
  		'variant' => 'warning',
  		'icon' => 'restore',
  		'title' => 'Successfully restored!',
  		'message' => $user->username.' has been restored.',
      'actions' => [
        [
          'label' => 'Undo',
          'url' => route('users.destroy', $user->id),
          'method' => 'delete',
        ],
      ]
  	]);
  }

  public function restoreMultiple(Request $request)
  {
  	// db transaction
  	\DB::transaction(function () use ($request) {
  		User::withTrashed()->whereIn('id', $request->ids)->get()->each->restore();
  	});

  	return redirect()->back()->with('notification', [
  		'variant' => 'warning',
  		'icon' => 'restore',
  		'title' => 'Successfully restored!',
  		'message' => count($request->ids).' users restored.',
      'actions' => [
        [
          'label' => 'Undo',
          'url' => route('users.destroy-multiple'),
          'method' => 'delete',
          'data' => [
            'ids' => $request->ids,
          ],
        ],
      ]
  	]);
  }
}
