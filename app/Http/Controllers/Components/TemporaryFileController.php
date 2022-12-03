<?php

namespace App\Http\Controllers\Components;

use App\Models\TemporaryFile;
use App\Services\TemporaryFileService;
use Illuminate\Http\Request;

class TemporaryFileController
{
	public function store(Request $request)
	{
		$data = (new TemporaryFileService())->store($request);

		return response()->json($data, 200);
	}

  public function destroy($folder)
  {
  	$temporaryFile = TemporaryFile::whereFolder($folder)->first();

  	(new TemporaryFileService())->destroy($temporaryFile);

  	return response()->json('Deleted Successfully', 200);
  }
}
