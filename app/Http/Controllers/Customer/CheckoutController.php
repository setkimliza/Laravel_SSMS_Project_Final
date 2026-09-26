<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display checkout page.
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your shopping cart is empty. Please add items before checking out.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $tax = round($subtotal * 0.05, 2);
        $total = $subtotal + $tax;
        $user = Auth::guard('web')->user();

        return view('customer.checkout', compact('cart', 'subtotal', 'tax', 'total', 'user'));
    }

    /**
     * Process checkout transaction.
     */
    public function process(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your shopping cart is empty.');
        }

        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:50'],
            'shipping_address' => ['required', 'string', 'max:500'],
            'payment_method' => ['required', 'in:Cash on Delivery,Credit/Debit Card,Online Banking'],
            'customer_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $user = Auth::guard('web')->user();

        // Update user contact if changed
        if ($user->phone !== $validated['phone'] || $user->address !== $validated['shipping_address']) {
            $user->update([
                'phone' => $validated['phone'],
                'address' => $validated['shipping_address'],
            ]);
        }

        try {
            $order = DB::transaction(function () use ($cart, $validated, $user) {
                $subtotal = 0;

                // 1. Verify stock availability for all cart items
                foreach ($cart as $id => $item) {
                    $product = Product::lockForUpdate()->find($id);

                    if (!$product) {
                        throw new \Exception("Product '{$item['name']}' is no longer available.");
                    }

                    if ($product->Qty < $item['quantity']) {
                        throw new \Exception("Insufficient stock for '{$product->PName}'. Only {$product->Qty} left.");
                    }

                    if ($product->isExpired()) {
                        throw new \Exception("Product '{$product->PName}' has expired and cannot be purchased.");
                    }

                    $subtotal += $product->Price * $item['quantity'];
                }

                $tax = round($subtotal * 0.05, 2);
                $total = $subtotal + $tax;

                // 2. Create Order record
                $order = Order::create([
                    'UserID' => $user->id,
                    'TotalAmount' => $total,
                    'OrderDate' => Carbon::now(),
                    'Status' => 'Completed',
                    'payment_method' => $validated['payment_method'],
                    'shipping_address' => $validated['shipping_address'],
                    'customer_notes' => $validated['customer_notes'] ?? null,
                ]);

                // 3. Create OrderDetail records and decrement stock
                foreach ($cart as $id => $item) {
                    $product = Product::find($id);
                    $lineSubtotal = round($product->Price * $item['quantity'], 2);

                    OrderDetail::create([
                        'OrderID' => $order->OrderID,
                        'PID' => $product->PID,
                        'Quantity' => $item['quantity'],
                        'Price' => $product->Price,
                        'Subtotal' => $lineSubtotal,
                    ]);

                    // Deduce inventory stock
                    $product->decrement('Qty', $item['quantity']);
                }

                return $order;
            });

            // 4. Clear shopping cart
            session()->forget('cart');

            return redirect()->route('checkout.success', $order->OrderID)
                ->with('success', 'Order placed successfully! Thank you for your purchase.');

        } catch (\Exception $e) {
            return back()->with('error', 'Checkout failed: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Order success confirmation screen.
     */
    public function success($id)
    {
        $order = Order::with(['orderDetails.product'])->where('UserID', Auth::id())->findOrFail($id);
        return view('customer.order-success', compact('order'));
    }

    /**
     * User order history.
     */
    public function history()
    {
        $orders = Order::with('orderDetails.product')
            ->where('UserID', Auth::id())
            ->orderBy('OrderDate', 'desc')
            ->paginate(10);

        return view('customer.order-history', compact('orders'));
    }

    /**
     * User order detail.
     */
    public function detail($id)
    {
        $order = Order::with('orderDetails.product.category')
            ->where('UserID', Auth::id())
            ->findOrFail($id);

        return view('customer.order-view', compact('order'));
    }
}
