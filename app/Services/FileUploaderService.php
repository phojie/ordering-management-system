<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Item;
use App\Models\TemporaryFile;
use App\Models\User;

class FileUploaderService
{
	public function uploadUserAvatarToMedia(string $id, string $avatar): void
	{
		try {
			$temporaryFile = TemporaryFile::where('folder', $avatar)->first();
      if($temporaryFile) {
			$user = User::findOrFail($id);
			$user->addMedia(storage_path('app/public/tmp/'.$avatar.'/'.$temporaryFile->filename))
					->toMediaCollection('avatar');

			(new TemporaryFileService())->delete($temporaryFile->folder);
    }

		} catch (\Exception $e) {
			throw $e;
		}
	}

  public function uploadItemImageToMedia(string $id, string $image): void
  {
  	try {
  		$temporaryFile = TemporaryFile::where('folder', $image)->first();
      if($temporaryFile) {
  		$item = Item::findOrFail($id);
  		$item->addMedia(storage_path('app/public/tmp/'.$image.'/'.$temporaryFile->filename))
  				->toMediaCollection('image');

  		(new TemporaryFileService())->delete($temporaryFile->folder);
    }

  	} catch (\Exception $e) {
  		throw $e;
  	}
  }

  public function deleteUserAvatarFromMedia(string $id): void
  {
  	try {
  		$user = User::findOrFail($id);
  		$user->clearMediaCollection('avatar');
  	} catch (\Exception $e) {
  		throw $e;
  	}
  }

  public function deleteItemImageFromMedia(string $id): void
  {
  	try {
  		$item = Item::findOrFail($id);
  		$item->clearMediaCollection('image');
  	} catch (\Exception $e) {
  		throw $e;
  	}
  }
}
