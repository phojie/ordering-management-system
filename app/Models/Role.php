<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
	use HasUuids;

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
}
