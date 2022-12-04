<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use HasFactory;
	use HasUuids;
	use SoftDeletes;

	public $guarded = [
		'id',
		'created_at',
		'updated_at',
		'deleted_at',
	];

  protected $appends = [
		'status',
	];

  public function getStatusAttribute()
	{
		return $this->deleted_at ? 'deleted' : 'active';
	}

	public function scopeSearch($query, $search): object
	{
		return $query->when($search, fn ($q) => $q->where('name', 'ilike', "%{$search}%")
		  ->orWhere('description', 'ilike', "%{$search}%"));
	}
}
