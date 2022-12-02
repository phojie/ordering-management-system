<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\TemporaryFile;
use App\Models\User;

class FileUploaderService
{
	public function uploadUserAvatarToMedia($id, $avatar)
	{
		$temporaryFile = TemporaryFile::where('folder', $avatar)->first();

		if ($temporaryFile) {
			$user = User::findOrFail($id);
			$user->addMedia(storage_path('app/public/tmp/'.$avatar.'/'.$temporaryFile->filename))
				->toMediaCollection('avatar');

			(new TemporaryFileService())->destroy($temporaryFile);
		}
	}
}
