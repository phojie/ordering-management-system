<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
	use HasUuids;

	public const Validation_Rules = [
		'name' => ['required', 'unique:permissions'],
	];

	protected $casts = [
		'model_id' => 'string',
	];
}
