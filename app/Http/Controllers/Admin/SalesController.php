<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Sales & Reports overview dashboard.
     */
    public function index(Request $request)
    {
        $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->subDays(30)->startOfDay();
        $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        // Total sales in range
        $totalSales = Order::whereBetween('OrderDate', [$startDate, $endDate])
            ->where('Status', 'Completed')
            ->sum('TotalAmount');

        $totalOrders = Order::whereBetween('OrderDate', [$startDate, $endDate])->count();

        $totalProductsSold = OrderDetail::join('orders', 'order_details.OrderID', '=', 'orders.OrderID')
            ->whereBetween('orders.OrderDate', [$startDate, $endDate])
            ->where('orders.Status', 'Completed')
            ->sum('order_details.Quantity');

        // Top Selling Products
        $topProducts = OrderDetail::join('orders', 'order_details.OrderID', '=', 'orders.OrderID')
            ->join('products', 'order_details.PID', '=', 'products.PID')
            ->whereBetween('orders.OrderDate', [$startDate, $endDate])
            ->where('orders.Status', 'Completed')
            ->select('products.PID', 'products.PName', DB::raw('SUM(order_details.Quantity) as total_qty'), DB::raw('SUM(order_details.Subtotal) as total_revenue'))
            ->groupBy('products.PID', 'products.PName')
            ->orderByDesc('total_qty')
            ->take(10)
            ->get();

        // Top Selling Categories
        $topCategories = OrderDetail::join('orders', 'order_details.OrderID', '=', 'orders.OrderID')
            ->join('products', 'order_details.PID', '=', 'products.PID')
            ->join('categories', 'products.CatID', '=', 'categories.CatID')
            ->whereBetween('orders.OrderDate', [$startDate, $endDate])
            ->where('orders.Status', 'Completed')
            ->select('categories.CatID', 'categories.name as category_name', DB::raw('SUM(order_details.Quantity) as total_qty'), DB::raw('SUM(order_details.Subtotal) as total_revenue'))
            ->groupBy('categories.CatID', 'categories.name')
            ->orderByDesc('total_qty')
            ->take(10)
            ->get();

        // Daily breakdown in date range for chart
        $dailySales = Order::whereBetween('OrderDate', [$startDate, $endDate])
            ->where('Status', 'Completed')
            ->select(DB::raw('DATE(OrderDate) as date'), DB::raw('SUM(TotalAmount) as revenue'), DB::raw('COUNT(*) as orders_count'))
            ->groupBy(DB::raw('DATE(OrderDate)'))
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.sales.index', compact(
            'startDate',
            'endDate',
            'totalSales',
            'totalOrders',
            'totalProductsSold',
            'topProducts',
            'topCategories',
            'dailySales'
        ));
    }

    /**
     * View all orders with search and status filters.
     */
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'orderDetails.product']);

        if ($request->filled('status')) {
            $query->where('Status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('OrderID', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->orderBy('OrderDate', 'desc')->paginate(12)->withQueryString();

        return view('admin.sales.orders', compact('orders'));
    }

    /**
     * Show single order detail / printable invoice.
     */
    public function showOrder($id)
    {
        $order = Order::with(['user', 'orderDetails.product.category'])->findOrFail($id);
        return view('admin.sales.order-detail', compact('order'));
    }

    /**
     * Update order status.
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Completed,Processing,Cancelled,Pending',
        ]);

        $order = Order::findOrFail($id);
        $order->Status = $request->status;
        $order->save();

        return back()->with('success', "Order #{$order->OrderID} status updated to {$order->Status}.");
    }
}
