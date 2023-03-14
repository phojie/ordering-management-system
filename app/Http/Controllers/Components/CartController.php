<?php

declare(strict_types=1);

namespace App\Http\Controllers\Components;

use App\Models\Cart;

class CartController
{
    public function count()
    {
        if (! auth()->check()) {
            return response()->json(0, 200);
        }

        $count = Cart::where('user_id', auth()->user()->id)->count();

        return response()->json($count, 200);
    }
}
