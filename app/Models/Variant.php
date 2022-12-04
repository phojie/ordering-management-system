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

	protected $appends = [
		'image',
	];

	public function getImageAttribute(): string
	{
		return $this->getFirstMediaUrl('image', 'thumb') ?: 'https://robohash.org/'.$this->id.'?set=set1&bgset=bg2&size=400x400';
	}

  public function registerMediaCollections(): void
  {
  	$this->addMediaCollection('image')
  		  ->singleFile();
  }

  public function registerMediaConversions(Media $media = null): void
  {
  	$this->addMediaConversion('image')
  		  ->width(400)
  		  ->height(400);
  }

	public static function boot(): void
	{
		parent::boot();
		self::creating(function ($model) {
			$model->color = (new MiscServices())->getRandomColor();
		});
	}
}
