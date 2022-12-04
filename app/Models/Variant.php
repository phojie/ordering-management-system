<?php

namespace App\Models;

use App\Services\MiscServices;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    use HasUuids;

    public $fillable = [
      'name',
      'status',
      'stock',
      'price',
      'item_id',
    ];

    public static function boot(): void
    {
      parent::boot();
      self::creating(function ($model) {
        $model->color = (new MiscServices())->getRandomColor();
      });
    }
}
