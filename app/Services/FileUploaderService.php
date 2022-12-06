<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\TemporaryFile;
use App\Models\User;

class FileUploaderService
{
	public function uploadUserAvatarToMedia(string $id, string $avatar): void
	{
		try {
			$temporaryFile = TemporaryFile::where('folder', $avatar)->firstOrFail();
			$user = User::findOrFail($id);
			$user->addMedia(storage_path('app/public/tmp/'.$avatar.'/'.$temporaryFile->filename))
					->toMediaCollection('avatar');

			(new TemporaryFileService())->delete($temporaryFile->folder);
		} catch (\Exception $e) {
			abort(500, $e->getMessage());
		}
	}
}
