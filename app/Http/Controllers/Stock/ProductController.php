<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->withCount('orderDetails');

        // Search by keyword
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('PName', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('PID', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('CatID', $request->category);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low') {
                $query->lowStock();
            } elseif ($request->stock_status === 'out') {
                $query->where('Qty', '<=', 0);
            } elseif ($request->stock_status === 'healthy') {
                $query->whereColumn('Qty', '>', 'MinStock');
            }
        }

        // Filter by expiration
        if ($request->filled('expiry_status')) {
            if ($request->expiry_status === 'expired') {
                $query->expired();
            } elseif ($request->expiry_status === 'expiring_soon') {
                $query->expiringSoon(30);
            }
        }

        $categories = Category::orderBy('name', 'asc')->get();
        $products = $query->orderBy('PID', 'desc')->paginate(12)->withQueryString();

        return view('stock.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('stock.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'PName' => ['required', 'string', 'max:255'],
            'CatID' => ['required', 'exists:categories,CatID'],
            'Qty' => ['required', 'integer', 'min:0'],
            'MinStock' => ['required', 'integer', 'min:0'],
            'Price' => ['required', 'numeric', 'min:0.01'],
            'ExpiredDate' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        Product::create($validated);

        return redirect()->route('stock.products.index')->with('success', 'Product registered successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name', 'asc')->get();
        return view('stock.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'PName' => ['required', 'string', 'max:255'],
            'CatID' => ['required', 'exists:categories,CatID'],
            'Qty' => ['required', 'integer', 'min:0'],
            'MinStock' => ['required', 'integer', 'min:0'],
            'Price' => ['required', 'numeric', 'min:0.01'],
            'ExpiredDate' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if stored locally
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('stock.products.index')->with('success', 'Product updated successfully!');
    }

    public function quickStockUpdate(Request $request, $id)
    {
        $request->validate([
            'Qty' => 'required|integer|min:0',
            'ExpiredDate' => 'nullable|date',
        ]);

        $product = Product::findOrFail($id);
        $oldQty = $product->Qty;
        $product->Qty = $request->Qty;

        $dateUpdated = false;
        if ($request->filled('ExpiredDate')) {
            $product->ExpiredDate = $request->ExpiredDate;
            $dateUpdated = true;
        }

        $product->save();

        $msg = "Stock updated for '{$product->PName}': {$oldQty} → {$product->Qty} units.";
        if ($dateUpdated) {
            $msg .= " New shelf expiration date set: " . Carbon::parse($product->ExpiredDate)->format('M d, Y') . ".";
        }

        return back()->with('success', $msg);
    }

    /**
     * Pull expired items from shelves and write them off as discard/waste.
     */
    public function discardExpired($id)
    {
        $product = Product::findOrFail($id);
        $discardedUnits = $product->Qty;

        $product->Qty = 0;
        $product->save();

        return back()->with('success', "Pulled & discarded {$discardedUnits} expired unit(s) of '{$product->PName}' from supermarket shelves. Recorded as Spoilage/Waste Write-off.");
    }

    public function destroy($id)
    {
        $product = Product::withCount('orderDetails')->findOrFail($id);

        if ($product->order_details_count > 0) {
            return back()->with('error', "Cannot delete '{$product->PName}' because it has {$product->order_details_count} linked order transaction(s). You can set its quantity to 0 instead.");
        }

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('stock.products.index')->with('success', 'Product deleted successfully.');
    }
}
