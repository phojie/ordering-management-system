<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Item extends Model implements HasMedia
{
	use HasFactory;
	use HasUuids;
	use SoftDeletes;
	use InteractsWithMedia;

	public $fillable = [
		'name',
		'description',
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

	public function variants(): HasMany
	{
		return $this->hasMany(Variant::class);
	}

	public function scopeSearch($query, $search): object
	{
		return $query->when($search, fn ($q) => $q->where('name', 'ilike', "%{$search}%")
		->orWhere('description', 'ilike', "%{$search}%"));
	}
}
