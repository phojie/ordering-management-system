<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\MiscServices;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
        'stock',
        'price',
        'product_id',
    ];

    protected $casts = [
        'stock' => 'integer',
        'price' => 'float',
    ];

    protected $appends = [
        'in_stock',
    ];

    public function getInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    public static function boot(): void
    {
        parent::boot();
        self::creating(function ($model) {
            $model->color = (new MiscServices())->getRandomColor();
        });
    }
}
