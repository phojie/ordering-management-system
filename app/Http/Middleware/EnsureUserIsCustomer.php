<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class EnsureUserIsCustomer
{
    public function handle(Request $request, Closure $next)
    {
        $user = User::find($request->user()->id);

        if ($user->hasRole('Admin') && ! $user->hasRole('Customer')) {
            return redirect()->route('admin.index');
        }

        return $next($request);
    }
}
