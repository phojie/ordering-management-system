<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Controller;

class UserController extends Controller
{
	public function index(Request $request)
	{
		$users = User::query()
		  ->where('id', '!=', auth()->user()->id)
		  ->when($request->search, function ($query, $search) {
		  	$query->where('username', 'ilike', "%{$search}%")
		  	->orWhere('email', 'ilike', "%{$search}%")
		  	->orWhere('first_name', 'ilike', "%{$search}%");
		  })
		  ->orderBy('created_at', 'desc')
		  ->paginate(15)
			->appends($request->all());

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
		User::whereIn('id', $request->ids)->delete();

		return redirect()->back()->with('notification', [
			'type' => 'success',
			'title' => count($request->ids).' users deleted successfully.',
		]);
	}
}
