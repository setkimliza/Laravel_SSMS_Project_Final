<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $id => $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // 5% standard sales tax or 0
        $tax = $subtotal > 0 ? round($subtotal * 0.05, 2) : 0;
        $total = $subtotal + $tax;

        return view('customer.cart', compact('cart', 'subtotal', 'tax', 'total'));
    }

    /**
     * Add product to cart.
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->Qty <= 0) {
            return back()->with('error', 'Sorry, this product is currently out of stock.');
        }

        if ($product->isExpired()) {
            return back()->with('error', 'This product has expired and cannot be sold.');
        }

        $quantity = (int) $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $cart = session()->get('cart', []);

        $currentInCart = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
        $newTotal = $currentInCart + $quantity;

        if ($newTotal > $product->Qty) {
            return back()->with('error', "Only {$product->Qty} item(s) available in stock. You already have {$currentInCart} in your cart.");
        }

        $cart[$id] = [
            'pid' => $product->PID,
            'name' => $product->PName,
            'price' => (float) $product->Price,
            'quantity' => $newTotal,
            'image' => $product->image_url,
            'stock' => $product->Qty,
            'category' => $product->category ? $product->category->name : 'General',
        ];

        session()->put('cart', $cart);

        if ($request->input('action') === 'buy_now') {
            return redirect()->route('cart.index')->with('success', "'{$product->PName}' was added to your cart!");
        }

        return back()->with('success', "'{$product->PName}' was added to your cart!");
    }

    /**
     * Update quantity of an item in cart.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = (int) $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return back()->with('error', 'Item not found in cart.');
        }

        if ($quantity <= 0) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return back()->with('success', 'Item removed from cart.');
        }

        if ($quantity > $product->Qty) {
            return back()->with('error', "Requested quantity exceeds available stock ({$product->Qty} units).");
        }

        $cart[$id]['quantity'] = $quantity;
        session()->put('cart', $cart);

        return back()->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove item from cart.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item removed from cart.');
    }

    /**
     * Clear all items from cart.
     */
    public function clear()
    {
        session()->forget('cart');
        return back()->with('info', 'Shopping cart cleared.');
    }
}
