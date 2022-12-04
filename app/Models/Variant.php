<?php

namespace App\Models;

use App\Services\MiscServices;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Variant extends Model implements HasMedia
{
	use HasFactory;
	use HasUuids;
	use InteractsWithMedia;

	public $fillable = [
		'name',
		'status',
		'stock',
		'price',
		'item_id',
	];


	public static function boot(): void
	{
		parent::boot();
		self::creating(function ($model) {
			$model->color = (new MiscServices())->getRandomColor();
		});
	}
}
