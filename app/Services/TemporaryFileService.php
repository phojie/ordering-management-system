<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\TemporaryFile;

class TemporaryFileService
{
	public function store($request): string
	{
		try {
			$file = $request->file('filepond');
			$filename = $file->getClientOriginalName();

			$folder = uniqid().'-'.now()->timestamp;
			$file->storeAs('/public/tmp/'.$folder, $filename);

			TemporaryFile::create([
				'folder' => $folder,
				'filename' => $filename,
			]);

			return $folder;
		} catch (\Exception $e) {
			(new FlashNotification())->error($e->getMessage());
		}
	}

	public function delete(string $folder): void
	{
		try {
			$temporaryFile = TemporaryFile::whereFolder($folder)->first();

			\Storage::deleteDirectory('/public/tmp/'.$folder);

			$temporaryFile->delete();
		} catch (\Exception $e) {
			(new FlashNotification())->error($e->getMessage());
		}
	}
}
