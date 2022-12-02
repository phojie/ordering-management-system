<?php

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
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
	 * @param  \Illuminate\Http\Request  $request
	 * @return string|null
	 */
	public function version(Request $request)
	{
		return parent::version($request);
	}

	/**
	 * Define the props that are shared by default.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return mixed[]
	 */
	public function share(Request $request)
	{
		$isAuth = Auth::check();

		return array_merge(parent::share($request), [
			'auth' => [
				'signedIn' =>$isAuth,
				'user' => $isAuth
					? new UserResource(Auth::user())
					: null,
			],
			'flash' => [
				'notification' => session('notification'),
			],
			// csrf token
			'csrfToken' => csrf_token(),
			// 'ziggy' => function () use ($request) {
			//     return array_merge((new Ziggy)->toArray(), [
			//         'location' => $request->url(),
			//     ]);
			// },
		]);
	}
}
