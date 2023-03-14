<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    use HasUuids;

    protected $casts = [
        'model_id' => 'string',
    ];

    protected $hidden = [
        'pivot',
        'guard_name',
        'created_at',
        'updated_at',
    ];
}
