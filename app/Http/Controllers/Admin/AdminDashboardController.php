<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalStaff = Staff::count();
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalSales = Order::where('Status', 'Completed')->sum('TotalAmount');

        $lowStockCount = Product::lowStock()->count();
        $expiredCount = Product::expired()->count();
        $expiringSoonCount = Product::expiringSoon(30)->count();

        // Sample list of low stock and expired products for quick review
        $lowStockProducts = Product::lowStock()->with('category')->take(5)->get();
        $expiredProducts = Product::expired()->with('category')->take(5)->get();

        // Recent orders
        $recentOrders = Order::with('user')->orderBy('OrderDate', 'desc')->take(6)->get();

        // Top Selling Products (by quantity sold)
        $topProducts = OrderDetail::select('PID', DB::raw('SUM(Quantity) as total_qty'), DB::raw('SUM(Subtotal) as total_revenue'))
            ->groupBy('PID')
            ->orderByDesc('total_qty')
            ->with('product')
            ->take(5)
            ->get();

        // Top Selling Categories
        $topCategories = DB::table('order_details')
            ->join('products', 'order_details.PID', '=', 'products.PID')
            ->join('categories', 'products.CatID', '=', 'categories.CatID')
            ->select('categories.name as category_name', DB::raw('SUM(order_details.Quantity) as total_sold'))
            ->groupBy('categories.CatID', 'categories.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Last 7 days sales chart data
        $salesTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $amount = Order::whereDate('OrderDate', $date)->where('Status', 'Completed')->sum('TotalAmount');
            $salesTrend[] = [
                'date' => $date->format('M d'),
                'amount' => (float) $amount,
            ];
        }

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalStaff',
            'totalUsers',
            'totalOrders',
            'totalSales',
            'lowStockCount',
            'expiredCount',
            'expiringSoonCount',
            'lowStockProducts',
            'expiredProducts',
            'recentOrders',
            'topProducts',
            'topCategories',
            'salesTrend'
        ));
    }
}
