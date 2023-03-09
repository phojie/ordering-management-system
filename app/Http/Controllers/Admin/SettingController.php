<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\FlashNotification;
use App\Services\UserService;

class SettingController
{
    protected $user;

    public function __construct()
    {
        $this->user = User::findOrFail(auth()->id());
    }

    public function index()
    {
        return inertia('Admin/Settings');
    }

    public function updateGeneral(UserRequest $request)
    {
        (new UserService())->update($request, $this->user);

        (new FlashNotification())->update('Your profile');

        return redirect()->back();
    }

    public function updatePassword(UserRequest $request)
    {
        (new UserService())->changePassword($request->newPassword, $this->user);

        (new FlashNotification())->update('Your password');

        return redirect()->back();
    }
}
