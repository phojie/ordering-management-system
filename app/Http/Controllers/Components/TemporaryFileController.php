<?php

declare(strict_types=1);

namespace App\Http\Controllers\Components;

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
      (new TemporaryFileService())->delete($folder);

      return response()->json('Deleted Successfully', 200);
  }
}
