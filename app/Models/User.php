<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasUuids;
    use SoftDeletes;
    use HasRoles;
    use InteractsWithMedia;

    protected $fillable = [
        'username',
        'email',
        'phone',
        'first_name',
        'middle_name',
        'last_name',
        'full_name',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'avatar',
    ];

    protected $with = [
        'address',
    ];

    protected function avatar(): Attribute
    {
        return Attribute::make(
            fn ($value) => $this->getFirstMediaUrl('avatar', 'thumb') ?: 'https://robohash.org/'.$this->id.'?set=set1&bgset=bg2&size=400x400',
        );
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function scopeSearch($query, $search): object
    {
        return $query->when($search, fn ($q) => $q->where('username', 'ilike', "%$search%")
            ->orWhere('first_name', 'ilike', "%$search%")
            ->orWhere('last_name', 'ilike', "%$search%")
            ->orWhere('full_name', 'ilike', "%$search%")
            ->orWhereHas('roles', fn ($q) => $q->where('name', 'ilike', "%$search%")));
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
             ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('avatar')
            ->width(180)
            ->height(180);
    }
}
