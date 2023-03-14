<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Inertia\Inertia;

class DashboardController
{
    public function index()
    {
        $totalCustomers = User::role('Customer')->count();
        $totalCustomersStat = [
            'name' => 'Total Customers',
            'stat' => $totalCustomers,
            'previousStat' => 0,
            'change' => 0,
            'changeType' => 'increase',
        ];

        $totalCategories = Category::count();
        $totalCategoriesStat = [
            'name' => 'Total Categories',
            'stat' => $totalCategories,
            'previousStat' => 0,
            'change' => 0,
            'changeType' => 'increase',
        ];

        $totalProducts = Product::count();
        $totalProductsStat = [
            'name' => 'Total Products',
            'stat' => $totalProducts,
            'previousStat' => 0,
            'change' => 0,
            'changeType' => 'increase',
        ];

        $orders = Order::query()
                  ->latest()
                  ->limit(10)
                  ->get();

        $orders = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'name' => "Order by $order->name",
                'href' => '#',
                'amount' => $order->total_amount,
                'currency' => 'PHP',
                'status' => $order->status,
                'date' => $order->created_at,
                'datetime' => $order->created_at,
            ];
        });

        // get all categories name and id
        // $categories = Category::withCount('orderVariants')->all(['id', 'name']);

        // get all product and its total order variants
        $products = Product::with('orderVariants')->get();
        $products = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'orderVariantsQuantity' => $product->orderVariants->sum('quantity'),
            ];
        });

        return Inertia::render('Admin/Index', [
            'stats' => [
                $totalCustomersStat,
                $totalCategoriesStat,
                $totalProductsStat,
            ],
            'transactions' => $orders,
            'ordersProductQuantity' => [
                'categories' => $products->pluck('name'),
                'series' => $products->pluck('orderVariantsQuantity'),
            ],
        ]);
    }
}
