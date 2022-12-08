<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Services\FlashNotification;
use App\Services\ItemService;
use Illuminate\Http\Request;

class ItemController
{
	public function index(Request $request)
	{
		abort_unless(\Gate::allows('item-list'), 404);

		// set query
		$query = (new ItemService())->get($request);

		// set pagination
		$items = $query->paginate($request->rows ?? config('jie.per_page'))->appends($request->all());

		// set resource
		$query = ItemResource::collection($items);

		return inertia('Admin/Items/Index', [
			'items' => $query,
		]);
	}

	public function store(ItemRequest $request)
	{
		\Gate::authorize('item-create');

		(new ItemService())->store($request);

		(new FlashNotification())->create($request->name);

		return redirect()->back();
	}

	public function show($id)
	{
	}

	public function update(ItemRequest $request, Item $item)
	{
		\Gate::authorize('item-update');

		(new ItemService())->update($request, $item);

		(new FlashNotification)->update($request->name);

		return redirect()->back();
	}

	public function destroy(Item $item)
	{
		\Gate::authorize('item-delete');

		(new ItemService())->delete($item->id);

		(new FlashNotification)->destroy($item->name, [
			[
				'url' => route('items.restore', $item->id),
				'method' => 'put',
			],
		]);

		return redirect()->back();
	}

  public function destroyMultiple(Request $request)
  {
  	\Gate::authorize('item-delete');

  	(new ItemService())->deleteMultiple($request->ids);

  	(new FlashNotification)->destroy(count($request->ids).' items', [
  		[
  			'url' => route('items.restore-multiple'),
  			'method' => 'put',
  			'data' => [
  				'ids' => $request->ids,
  			],
  		],
  	]);

  	return redirect()->back();
  }

  public function restore(Item $item)
  {
  	\Gate::authorize('item-delete');

  	(new ItemService())->restore($item->id);

  	(new FlashNotification)->restore($item->name, [
  		[
  			'url' => route('items.destroy', $item->id),
  			'method' => 'delete',
  		],
  	]);

  	return redirect()->back();
  }

  public function restoreMultiple(Request $request)
  {
  	\Gate::authorize('item-delete');

  	(new ItemService())->retoreMultiple($request->ids);

  	(new FlashNotification)->restore(count($request->ids).' items', [
  		[
  			'url' => route('items.destroy-multiple'),
  			'method' => 'delete',
  			'data' => [
  				'ids' => $request->ids,
  			],
  		],
  	]);

  	return redirect()->back();
  }
}
