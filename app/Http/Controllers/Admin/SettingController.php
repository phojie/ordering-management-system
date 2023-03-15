<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\FlashNotification;
use App\Services\UserService;

class SettingController
{
    public User $user;
    public function __construct(User $user)
    {
        $this->user = $user->find(auth()->user()->id);
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
