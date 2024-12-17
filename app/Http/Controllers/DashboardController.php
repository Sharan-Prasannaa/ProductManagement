<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index(){
        $totalProducts = Product::count();
        $totalSuppliers = Supplier::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();

        $revenueLast30Days = Order::where('created_at', '>=', Carbon::now()->subDays(30)) //Carbon is a library to fetch current date and time. subDays -> subtract days.
                                    ->where('status', 'completed')
                                    ->sum('total_amount');

        $top5Products = Product::withCount(['orderItems as total_sold' => function ($query) {
                    $query->select(DB::raw('SUM(quantity)'));
        }])->orderBy('total_sold','desc')
        ->take(5)
        ->get();

        // For each product in the products table,
        // ->Look at all its related orderItems
        // ->Sum the quantity of all these orderItems.
        // ->Store this total as total_sold
        //DB::raw('SUM(quantity)') creates a SQL expression to sum the quantity of the orderItems
        // ->This computed total_sold value is then available as an attribute on the Product model. For example, you can access it in a view using $product->total_sold.

        return view('dashboard',compact(
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'totalOrders',
            'revenueLast30Days',
            'top5Products'
        ));

    }
}
