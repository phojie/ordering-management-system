<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'address1',
        'address2',
        'city',
        'province',
        'postal_code',
        'country',
        'user_id',
    ];

    protected $appends = [
        'full_address',
    ];

    public function getFullAddressAttribute(): string
    {
        // '.$this->address2.',
        return $this->address1.', '.$this->city.', '.$this->province.', '.$this->postal_code.', '.$this->country;
    }

      public function user(): BelongsTo
      {
          return $this->belongsTo(User::class);
      }
}
