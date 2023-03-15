<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\TemporaryFile;
use App\Models\User;
use Exception;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class FileUploaderService
{
    public function uploadUserAvatarToMedia(string $id, string $avatar): void
    {
        $temporaryFile = TemporaryFile::where('folder', $avatar)->first();
        if ($temporaryFile) {
            $user = User::findOrFail($id);
            try {
                $user->addMedia(storage_path('app/public/tmp/' . $avatar . '/' . $temporaryFile->filename))
                    ->toMediaCollection('avatar');
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                // do nothing
            }

            try {
                (new TemporaryFileService())->delete($temporaryFile->folder);
            } catch (Exception $e) {
                // do nothing
            }
        }
    }

    public function uploadProductImageToMedia(string $id, string $image): void
    {
        $temporaryFile = TemporaryFile::where('folder', $image)->first();
        if ($temporaryFile) {
            $product = Product::findOrFail($id);
            try {
                $product->addMedia(storage_path('app/public/tmp/' . $image . '/' . $temporaryFile->filename))
                    ->toMediaCollection('image');
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                // do nothing
            }

            (new TemporaryFileService())->delete($temporaryFile->folder);
        }
    }

    public function uploadCategoryImageToMedia(string $id, string $image): void
    {
        $temporaryFile = TemporaryFile::where('folder', $image)->first();
        if ($temporaryFile) {
            $product = Category::findOrFail($id);
            try {
                $product->addMedia(storage_path('app/public/tmp/' . $image . '/' . $temporaryFile->filename))
                    ->toMediaCollection('image');
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                // do nothing
            }

            try {
                (new TemporaryFileService())->delete($temporaryFile->folder);
            } catch (Exception $e) {
                // do nothing
            }
        }
    }
    public function deleteUserAvatarFromMedia(string $id): void
    {
        $user = User::findOrFail($id);
        $user->clearMediaCollection('avatar');
    }

    public function deleteProductImageFromMedia(string $id): void
    {
        $product = Product::findOrFail($id);
        $product->clearMediaCollection('image');
    }

    public function deleteCategoryImageFromMedia(string $id): void
    {
        $product = Category::findOrFail($id);
        $product->clearMediaCollection('image');
    }
}
