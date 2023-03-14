<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;
    use InteractsWithMedia;

    public $fillable = [
        'name',
        'description',
        'status',
    ];

    protected $appends = [
        'image',
    ];

    public function getImageAttribute(): string
    {
        return $this->getFirstMediaUrl('image', 'thumb') ?: 'https://robohash.org/'.$this->id.'?set=set1&bgset=bg2&size=600x600';
    }

  public function registerMediaCollections(): void
  {
      $this->addMediaCollection('image')
            ->singleFile();
  }

  public function registerMediaConversions(Media $media = null): void
  {
      $this->addMediaConversion('image')
            ->width(600)
            ->height(600);
  }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }

  public function categories(): BelongsToMany
  {
      return $this->belongsToMany(Category::class);
  }

  public function orderVariants(): HasMany
  {
      return $this->hasMany(OrderVariant::class);
  }

    public function scopeSearch($query, $search): object
    {
        return $query->when($search, fn ($q) => $q->where('name', 'ilike', "%{$search}%")
        ->orWhere('description', 'ilike', "%{$search}%"));
    }

  public function scopeAvailable($query): object
  {
      return $query->where('status', 'active');
  }
}
