<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
	use HasFactory;
	use HasUuids;
	use SoftDeletes;

	public $fillable = [
		'name',
		'description',
	];

	public function scopeSearch($query, $search): object
	{
		return $query->when($search, fn ($q) => $q->where('name', 'ilike', "%{$search}%")
		->orWhere('description', 'ilike', "%{$search}%"));
	}
}
