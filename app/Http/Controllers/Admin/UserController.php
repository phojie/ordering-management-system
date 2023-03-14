<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\FlashNotification;
use App\Services\UserService;
use Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Controller;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        abort_unless(Gate::allows('user-list'), 404);

        // set query
        $query = (new UserService())->get($request);

        // set pagination
        $users = $query->paginate($request->rows ?? config('jie.per_page'))->appends($request->all());

        // set resource
        $query = UserResource::collection($users);

        return inertia('Admin/Users/Index', [
            'users' => $query,
        ]);
    }

    /*
    public function show(User $user): Response
    {
    return inertia('Admin/Users/Show', [
       'user' => new UserResource($user),
    ]);
    }
    */

    public function store(UserRequest $request): RedirectResponse
    {
        Gate::authorize('user-create');

        (new UserService())->store($request);

        (new FlashNotification())->create($request->username);

        return redirect()->back();
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        Gate::authorize('user-update');

        (new UserService())->update($request, $user);

        (new FlashNotification())->update($request->username);

        return redirect()->back();
    }

    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('user-delete');

        (new UserService())->delete($user->id);

        (new FlashNotification())->destroy($user->username, [
            [
                'url' => route('admin.users.restore', $user->id),
                'method' => 'put',
            ],
        ]);

        return redirect()->back();
    }

    public function destroyMultiple(Request $request): RedirectResponse
    {
        Gate::authorize('user-delete');

        (new UserService())->deleteMultiple($request->ids);

        (new FlashNotification())->destroy(count($request->ids).' users', [
            [
                'url' => route('admin.users.restore-multiple'),
                'method' => 'put',
                'data' => [
                    'ids' => $request->ids,
                ],
            ],
        ]);

        return redirect()->back();
    }

    public function restore(User $user): RedirectResponse
    {
        Gate::authorize('user-delete');

        (new UserService())->restore($user->id);

        (new FlashNotification())->restore($user->username, [
            [
                'url' => route('admin.users.destroy', $user->id),
                'method' => 'delete',
            ],
        ]);

        return redirect()->back();
    }

    public function restoreMultiple(Request $request): RedirectResponse
    {
        Gate::authorize('user-delete');

        (new UserService())->retoreMultiple($request->ids);

        (new FlashNotification())->restore(count($request->ids).' users', [
            [
                'url' => route('admin.users.destroy-multiple'),
                'method' => 'delete',
                'data' => [
                    'ids' => $request->ids,
                ],
            ],
        ]);

        return redirect()->back();
    }
}
