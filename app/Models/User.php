<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
	use HasApiTokens;
	use HasFactory;
	use Notifiable;
	use HasUuids;
	use SoftDeletes;
	use HasRoles;

	protected $fillable = [
		'username',
		'email',
		'first_name',
		'middle_name',
		'last_name',
		'full_name',
		'image_url',
		'password',
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	public function scopeSearch($query, $search): object
	{
		return $query->where(function ($q) use ($search) {
			$q->where('username', 'ilike', "%{$search}%")
			  ->orWhere('email', 'ilike', "%{$search}%")
			  ->orWhere('full_name', 'ilike', "%{$search}%");
		});
	}
}
