<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
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

  public function uploadProductImageToMedia(string $id, string $image): void
  {
  	try {
  		$temporaryFile = TemporaryFile::where('folder', $image)->first();
      if($temporaryFile) {
  		$product = Product::findOrFail($id);
  		$product->addMedia(storage_path('app/public/tmp/'.$image.'/'.$temporaryFile->filename))
  				->toMediaCollection('image');

  		(new TemporaryFileService())->delete($temporaryFile->folder);
    }

  	} catch (\Exception $e) {
  		throw $e;
  	}
  }

  public function uploadCategoryImageToMedia(string $id, string $image): void
  {
  	try {
  		$temporaryFile = TemporaryFile::where('folder', $image)->first();
      if($temporaryFile) {
  		$product = Category::findOrFail($id);
  		$product->addMedia(storage_path('app/public/tmp/'.$image.'/'.$temporaryFile->filename))
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

  public function deleteProductImageFromMedia(string $id): void
  {
  	try {
  		$product = Product::findOrFail($id);
  		$product->clearMediaCollection('image');
  	} catch (\Exception $e) {
  		throw $e;
  	}
  }

    public function deleteCategoryImageFromMedia(string $id): void
  {
  	try {
  		$product = Category::findOrFail($id);
  		$product->clearMediaCollection('image');
  	} catch (\Exception $e) {
  		throw $e;
  	}
  }
}
