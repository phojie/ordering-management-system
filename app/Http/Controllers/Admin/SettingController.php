<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SettingRequest;
use App\Services\FlashNotification;
use App\Services\UserService;

class SettingController
{
	public function index()
	{
		return inertia('Admin/Settings');
	}

	public function updateGeneral(SettingRequest $request)
	{
		(new UserService())->update($request, auth()->id());

		(new FlashNotification())->update('Your profile');

		return redirect()->back();
	}

  public function updatePassword(SettingRequest $request)
  {
  	(new UserService())->changePassword($request->newPassword, auth()->id());

  	(new FlashNotification())->update('Your password');

  	return redirect()->back();
  }
}
