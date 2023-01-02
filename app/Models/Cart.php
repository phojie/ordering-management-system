<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Cart extends Model
{
	use HasFactory;
  use HasUuids;

	protected $fillable = [
		'user_id',
		'variant_id',
    'product_id',
		'quantity',
	];

  protected $casts = [
    'quantity' => 'integer',
  ];

	public function variant(): BelongsTo
	{
		return $this->belongsTo(Variant::class);
	}

  public function product(): BelongsTo {
    return $this->belongsTo(Product::class,);
  }
}
