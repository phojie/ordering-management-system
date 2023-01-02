<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class OrderVariant extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
      'order_id',
      'product_id',
      'variant_id',
      'quantity',
      'price',
      'total'
    ];
}
