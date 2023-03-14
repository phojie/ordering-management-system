<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
use App\Models\Order;
use Auth;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return mixed[]
     */
    public function share(Request $request)
    {
        $isAuth = Auth::check();
        $isAuthHasAdminRole = $isAuth ? Auth::user()->hasRole('Admin') : false;

        return array_merge(parent::share($request), [
            'auth' => [
                'signedIn' => $isAuth,
                'user' => $isAuth ? new UserResource(Auth::user()) : null,
                'permissions' => $isAuth ? Auth::user()->getAllPermissions()->pluck('name') : null,
                'roles' => $isAuth ? Auth::user()->getRoleNames() : null,
            ],
            'flash' => [
                'notification' => session('notification'),
                'success' => session('success'),
            ],
            'csrfToken' => csrf_token(),
            'cartCount' => $isAuth ? Auth::user()->carts->count() : 0,
            'pendingOrderCount' => $isAuthHasAdminRole ? (new Order())->countPending() : 0,

            // 'ziggy' => function () use ($request) {1
            //     return array_merge((new Ziggy)->toArray(), [
            //         'location' => $request->url(),
            //     ]);
            // },
        ]);
    }
}
