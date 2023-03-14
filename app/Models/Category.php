<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\MiscServices;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Category extends Model implements HasMedia
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $appends = [
        'status',
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

    public function getStatusAttribute(): string
    {
        return $this->deleted_at ? 'deleted' : 'active';
    }

    public function scopeSearch($query, $search): object
    {
        return $query->when($search, fn ($q) => $q->where('name', 'ilike', "%{$search}%")
          ->orWhere('description', 'ilike', "%{$search}%"));
    }

  public function products(): BelongsToMany
  {
      return $this->belongsToMany(Product::class);
  }

  public function orders(): BelongsToMany
  {
      return $this->belongsToMany(Order::class);
  }

  public function orderVariants(): BelongsToMany
  {
      return $this->belongsToMany(OrderVariant::class);
  }

    public static function boot(): void
    {
        parent::boot();
        self::creating(function ($model) {
            $model->color = (new MiscServices())->getRandomColor();
        });
    }
}
