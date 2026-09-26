<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StockDashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $lowStockCount = Product::lowStock()->count();
        $outOfStockCount = Product::where('Qty', '<=', 0)->count();
        $expiredCount = Product::expired()->count();
        $expiringSoonCount = Product::expiringSoon(30)->count();

        // Get critical items
        $lowStockProducts = Product::lowStock()->with('category')->orderBy('Qty', 'asc')->take(10)->get();
        $expiredProducts = Product::expired()->with('category')->orderBy('ExpiredDate', 'asc')->take(10)->get();
        $expiringSoonProducts = Product::expiringSoon(30)->with('category')->orderBy('ExpiredDate', 'asc')->take(10)->get();

        // Category breakdown
        $categoriesWithCounts = Category::withCount('products')->get();

        return view('stock.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'lowStockCount',
            'outOfStockCount',
            'expiredCount',
            'expiringSoonCount',
            'lowStockProducts',
            'expiredProducts',
            'expiringSoonProducts',
            'categoriesWithCounts'
        ));
    }

    /**
     * Dedicated low-stock & expiry report view.
     */
    public function inventoryAlerts(Request $request)
    {
        $filter = $request->get('filter', 'all');

        $query = Product::with('category');

        if ($filter === 'low_stock') {
            $query->lowStock();
        } elseif ($filter === 'expired') {
            $query->expired();
        } elseif ($filter === 'expiring_soon') {
            $query->expiringSoon(30);
        } else {
            $query->where(function ($q) {
                $q->lowStock()
                  ->orWhere(function ($eq) {
                      $eq->whereNotNull('ExpiredDate')->where('ExpiredDate', '<=', Carbon::today()->addDays(30));
                  });
            });
        }

        $products = $query->paginate(15)->withQueryString();

        return view('stock.alerts', compact('products', 'filter'));
    }
}
