<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\FlashNotification;
use Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class CategoryController
{
    public function index(Request $request): Response
    {
        abort_unless(Gate::allows('category-list'), 404);

        // set query
        $query = (new CategoryService())->get($request);

        // set pagination
        $categories = $query->paginate($request->rows ?? config('jie.per_page'))->appends($request->all());

        // set resource
        $query = CategoryResource::collection($categories);

        return inertia('Admin/Categories/Index', [
            'categories' => $query,
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('category-create'), 404);

        (new CategoryService())->store($request);

        (new FlashNotification())->create($request->name);

        return redirect()->back();
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        abort_unless(Gate::allows('category-update'), 404);

        (new CategoryService())->update($request, $category);

        (new FlashNotification())->update($request->name);

        return redirect()->back();
    }

    public function destroy(Category $category): RedirectResponse
    {
        abort_unless(Gate::allows('category-delete'), 404);

        (new CategoryService())->delete($category->id);

        (new FlashNotification())->destroy($category->name, [
            [
                'url' => route('admin.categories.restore', $category->id),
                'method' => 'put',
            ],
        ]);

        return redirect()->back();
    }

    public function destroyMultiple(Request $request): RedirectResponse
    {
        abort_unless(Gate::allows('category-delete'), 404);

        (new CategoryService())->deleteMultiple($request->ids);

        (new FlashNotification())->destroy(count($request->ids).' categories', [
            [
                'url' => route('admin.categories.restore-multiple'),
                'method' => 'put',
                'data' => [
                    'ids' => $request->ids,
                ],
            ],
        ]);

        return redirect()->back();
    }

    public function restore(Category $category): RedirectResponse
    {
        abort_unless(Gate::allows('category-delete'), 404);

        (new CategoryService())->restore($category->id);

        (new FlashNotification())->restore($category->name, [
            [
                'url' => route('admin.categories.destroy', $category->id),
                'method' => 'delete',
            ],
        ]);

        return redirect()->back();
    }

    public function restoreMultiple(Request $request): RedirectResponse
    {
        abort_unless(Gate::allows('category-delete'), 404);

        (new CategoryService())->retoreMultiple($request->ids ?? []);

        (new FlashNotification())->restore(count($request->ids ?? []).' categories', [
            [
                'url' => route('admin.categories.destroy-multiple'),
                'method' => 'delete',
                'data' => [
                    'ids' => $request->ids ?? [],
                ],
            ],
        ]);

        return redirect()->back();
    }
}
