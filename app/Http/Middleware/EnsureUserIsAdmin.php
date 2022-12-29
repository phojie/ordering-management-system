<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
	public function handle(Request $request, Closure $next): mixed
	{
		$user = User::find(auth()->user()->id);
		if (! $user->hasRole('Admin')) {
			return redirect()->route('dashboard');
		}

		return $next($request);
	}
}
