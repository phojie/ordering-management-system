<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class SettingController
{
    public function __invoke(Request $request)
    {
        return view('auth.settings');
    }
}
