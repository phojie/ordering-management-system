<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'order_number',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'status',

        'taxes_amount',
        'shipping_amount',
        'total_amount',

        'user_id',
        'delivered_at',
        'delivered_by',
    ];

    protected $casts = [
        'order_number' => 'integer',
        'taxes_amount' => 'float',
        'shipping_amount' => 'float',
        'total_amount' => 'float',
    ];

    public function orderVariants(): HasMany
    {
        return $this->hasMany(OrderVariant::class);
    }

  public function user(): BelongsTo
  {
      return $this->belongsTo(User::class);
  }

  public function countPending(): int
  {
      return $this->where('status', 'pending')->count();
  }

  public function scopeSearch($query, $search): object
  {
      return $query->when(
          $search,
          fn ($q) => $q->where('order_number', 'ilike', "%{$search}%")
            ->orWhere('name', 'ilike', "%{$search}%")
            ->orWhere('email', 'ilike', "%{$search}%")
            ->orWhere('phone', 'ilike', "%{$search}%")
            ->orWhere('address', 'ilike', "%{$search}%")
            ->orWhere('city', 'ilike', "%{$search}%")
            ->orWhere('province', 'ilike', "%{$search}%")
            ->orWhere('postal_code', 'ilike', "%{$search}%")
            ->orWhere('status', 'ilike', "%{$search}%")
      );
  }

  public function scopeFilterOrderNumber(Builder $query, $request): Builder
  {
      return $query->where('order_number', 'like', "%{$request}%");
  }
}
