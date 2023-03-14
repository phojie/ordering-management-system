<?php

declare(strict_types=1);

namespace App\Http\Controllers\Components;

use App\Services\UserService;

class UserController
{
    public function show($id)
    {
        $user = (new UserService())->show($id);

        return response()->json($user, 200);
    }
}
