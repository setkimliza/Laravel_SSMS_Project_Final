<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Storefront landing page.
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();

        // Curate 6 iconic supermarket staple deals matching real grocery sites
        $staplePids = [18, 25, 5, 24, 9, 48];
        $dealProducts = Product::whereIn('PID', $staplePids)
            ->with('category')
            ->get()
            ->sortBy(function ($model) use ($staplePids) {
                return array_search($model->PID, $staplePids);
            });

        // Fallback if any staple is missing
        if ($dealProducts->count() < 6) {
            $extra = Product::where('Qty', '>', 0)
                ->whereNotNull('image')
                ->whereNotIn('PID', $dealProducts->pluck('PID')->toArray())
                ->with('category')
                ->take(6 - $dealProducts->count())
                ->get();
            $dealProducts = $dealProducts->merge($extra);
        }

        // Popular picks (everyday household staples)
        $popularProducts = Product::where('Qty', '>', 0)
            ->whereNotNull('image')
            ->whereNotIn('PID', $dealProducts->pluck('PID')->toArray())
            ->with('category')
            ->take(8)
            ->get();

        // Fresh arrivals (latest products in stock)
        $latestProducts = Product::where('Qty', '>', 0)
            ->whereNotNull('image')
            ->with('category')
            ->orderBy('PID', 'desc')
            ->take(8)
            ->get();

        return view('customer.home', compact('categories', 'dealProducts', 'popularProducts', 'latestProducts'));
    }

    /**
     * Product catalog with search and filters.
     */
    public function catalog(Request $request)
    {
        $query = Product::with('category');

        // Only show products not expired to customer
        $query->where(function ($q) {
            $q->whereNull('ExpiredDate')
              ->orWhere('ExpiredDate', '>', now());
        });

        // Filter by category
        if ($request->filled('category')) {
            $query->where('CatID', $request->category);
        }

        // Search query
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('PName', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by availability
        if ($request->filled('in_stock') && $request->in_stock == '1') {
            $query->where('Qty', '>', 0);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('Price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('Price', 'desc');
                break;
            case 'name':
                $query->orderBy('PName', 'asc');
                break;
            default:
                $query->orderBy('PID', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();
        $selectedCategory = $request->filled('category') ? Category::find($request->category) : null;

        return view('customer.catalog', compact('products', 'categories', 'selectedCategory', 'sort'));
    }

    /**
     * Single product detail page.
     */
    public function productDetail($id)
    {
        $product = Product::with('category')->findOrFail($id);

        $relatedProducts = Product::where('CatID', $product->CatID)
            ->where('PID', '!=', $product->PID)
            ->where('Qty', '>', 0)
            ->take(4)
            ->get();

        return view('customer.product-detail', compact('product', 'relatedProducts'));
    }
}
