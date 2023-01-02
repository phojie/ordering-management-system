<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
	];

	protected $cast = [
		'taxes_amount' => 'float',
		'shipping_amount' => 'float',
		'total_amount' => 'float',
	];

	public function orderVariants(): HasMany
	{
		return $this->hasMany(OrderVariant::class);
	}
}
