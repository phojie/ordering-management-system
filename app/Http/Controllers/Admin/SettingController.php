<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class SettingController
{
    public function index(Request $request)
    {
      return inertia('Admin/Settings', [
      ]);
    }
}
