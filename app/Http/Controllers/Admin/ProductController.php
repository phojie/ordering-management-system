<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\FlashNotification;
use App\Services\ProductService;
use Gate;
use Illuminate\Http\Request;

class ProductController
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('product-list'), 404);

        // set query
        $query = (new ProductService())->get($request);

        // set pagination
        $products = $query->paginate($request->rows ?? config('jie.per_page'))->appends($request->all());

        // set resource
        $query = ProductResource::collection($products);

        return inertia('Admin/Products/Index', [
            'products' => $query,
        ]);
    }

    public function store(ProductRequest $request)
    {
        Gate::authorize('product-create');

        (new ProductService())->store($request);

        (new FlashNotification())->create($request->name);

        return redirect()->back();
    }

    public function show($id)
    {
    }

    public function update(ProductRequest $request, Product $product)
    {
        Gate::authorize('product-update');

        (new ProductService())->update($request, $product);

        (new FlashNotification())->update($request->name);

        return redirect()->back();
    }

    public function destroy(Product $product)
    {
        Gate::authorize('product-delete');

        (new ProductService())->delete($product->id);

        (new FlashNotification())->destroy($product->name, [
            [
                'url' => route('admin.products.restore', $product->id),
                'method' => 'put',
            ],
        ]);

        return redirect()->back();
    }

    public function destroyMultiple(Request $request)
    {
        Gate::authorize('product-delete');

        (new ProductService())->deleteMultiple($request->ids);

        (new FlashNotification())->destroy(count($request->ids).' products', [
            [
                'url' => route('admin.products.restore-multiple'),
                'method' => 'put',
                'data' => [
                    'ids' => $request->ids,
                ],
            ],
        ]);

        return redirect()->back();
    }

    public function restore(Product $product)
    {
        Gate::authorize('product-delete');

        (new ProductService())->restore($product->id);

        (new FlashNotification())->restore($product->name, [
            [
                'url' => route('admin.products.destroy', $product->id),
                'method' => 'delete',
            ],
        ]);

        return redirect()->back();
    }

    public function restoreMultiple(Request $request)
    {
        Gate::authorize('product-delete');

        (new ProductService())->retoreMultiple($request->ids);

        (new FlashNotification())->restore(count($request->ids).' products', [
            [
                'url' => route('admin.products.destroy-multiple'),
                'method' => 'delete',
                'data' => [
                    'ids' => $request->ids,
                ],
            ],
        ]);

        return redirect()->back();
    }
}
