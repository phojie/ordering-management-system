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
		$model = User::query()
					->withTrashed()
		  ->where('id', '!=', auth()->user()->id);

		// set query builder
		$query = QueryBuilder::for($model)
		  ->allowedSorts(['full_name', 'status']);
		// ->allowedFilters(['username', 'email', 'full_name']);

		// if request search
		if ($request->has('search')) {
			$query = $query->where('email', 'ilike', '%'.$request->search.'%')
			  ->orWhere('username', 'ilike', '%'.$request->search.'%')
			  ->orWhere('full_name', 'ilike', '%'.$request->search.'%');
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

	public function create()
	{
		//
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
			'type' => 'success',
			'title' => $userRequest->username.' has been created.',
		]);
	}

	public function show(User $user)
	{
		// get user
	}

	public function edit(User $user)
	{
		// edit user
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
  		'type' => 'success',
  		'title' => $userRequest->username.' has been updated.',
  	]);
  }

	public function destroy(User $user)
	{
		$user->delete();

		return redirect()->back()->with('notification', [
			'type' => 'success',
			'title' => $user->username.' has been deleted.',
		]);
	}

	public function destroyMultiple(Request $request)
	{
		User::whereIn('id', $request->ids)->get()->each->delete();

		return redirect()->back()->with('notification', [
			'type' => 'success',
			'title' => count($request->ids).' users deleted successfully.',
		]);
	}

  public function restore(User $user)
  {
  	$user->restore();

  	return redirect()->back()->with('notification', [
  		'type' => 'success',
  		'title' => $user->username.' has been restored.',
  	]);
  }

  public function restoreMultiple(Request $request)
  {
  	User::whereIn('id', $request->ids)->restore();

  	return redirect()->back()->with('notification', [
  		'type' => 'success',
  		'title' => count($request->ids).' users restored successfully.',
  	]);
  }
}
