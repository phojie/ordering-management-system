<?php

namespace App\Models;

use App\Services\MiscServices;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use HasFactory;
	use HasUuids;
	use SoftDeletes;

	protected $fillable = [
		'name',
		'description',
	];

	protected $appends = [
		'status',
	];

	public function getStatusAttribute(): string
	{
		return $this->deleted_at ? 'deleted' : 'active';
	}

	public function scopeSearch($query, $search): object
	{
		return $query->when($search, fn ($q) => $q->where('name', 'ilike', "%{$search}%")
		  ->orWhere('description', 'ilike', "%{$search}%"));
	}

	public static function boot(): void
	{
		parent::boot();
		self::creating(function ($model) {
			$model->color = (new MiscServices())->getRandomColor();
		});
	}
}
