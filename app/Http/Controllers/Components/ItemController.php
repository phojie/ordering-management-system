<?php

namespace App\Http\Controllers\Components;

use App\Http\Resources\ItemResource;
use App\Models\Item;

class ItemController
{
  public function index() {
    $query = Item::get();

    return response()->json($query, 200);
  }

	public function show($id)
	{
		$query = Item::query()
        ->with(['variants'])
				->find($id);
		$item = new ItemResource($query);

		return response()->json($item, 200);
	}
}
