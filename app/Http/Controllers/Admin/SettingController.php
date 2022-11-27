<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SettingRequest;
use App\Models\User;
use App\Services\FlashNotification;
use App\Services\UserService;

class SettingController
{
	public function index()
	{
		return inertia('Admin/Settings');
	}

	public function update(SettingRequest $request)
	{
    $user = User::find(auth()->id());

		(new UserService())->update($request, $user);

		(new FlashNotification())->update('Your profile');

		return redirect()->back();
	}
}
