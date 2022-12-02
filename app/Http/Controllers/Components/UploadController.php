<?php

namespace App\Http\Controllers\Components;

use App\Services\TemporaryFileService;
use Illuminate\Http\Request;

class UploadController
{
	public function store(Request $request)
	{
		$data = (new TemporaryFileService())->store($request);

		return response()->json($data, 200);
	}
}
