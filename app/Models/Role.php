<?php

namespace App\Models;

use App\Services\MiscServices;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
	use HasUuids;
  use SoftDeletes;

	public const Validation_Rules = [
		'name' => ['required', 'unique:roles'],
		'description' => 'required',
	];

	protected $hidden = [
		'pivot',
		'guard_name',
		'updated_at',
		'created_at',
	];

	protected $casts = [
		'model_id' => 'string',
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

  public static function boot()
  {
      parent::boot();
      self::creating(function ($model) {
          $model->color = (new MiscServices())->RandomColor();
      });
  }
}
