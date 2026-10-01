<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Order::count() > 0) {
            return;
        }

        $user1 = User::where('email', 'john@example.com')->first();
        $user2 = User::where('email', 'sarah@example.com')->first();

        if (!$user1 || !$user2) {
            $this->call(UserSeeder::class);
            $user1 = User::where('email', 'john@example.com')->first();
            $user2 = User::where('email', 'sarah@example.com')->first();
        }

        $coke = Product::where('PName', 'like', '%Coca-Cola%')->first();
        $lays = Product::where('PName', 'like', "%Lay's Classic%")->first();
        $milk = Product::where('PName', 'like', '%Cowhead%')->first();
        $donut = Product::where('PName', 'like', '%Chocolate Donuts%')->first();
        $watermelon = Product::where('PName', 'like', '%Watermelon%')->first();
        $cream = Product::where('PName', 'like', '%Beauty of Joseon%')->first();
        $dove = Product::where('PName', 'like', '%Dove Restoring%')->first();
        $banana = Product::where('PName', 'like', '%Bananas%')->first();
        $pocky = Product::where('PName', 'like', '%Pocky%')->first();
        $pringles = Product::where('PName', 'like', '%Pringles%')->first();

        // Order 1 (14 days ago)
        if ($user1 && $coke && $lays) {
            $order1 = Order::create([
                'UserID' => $user1->id,
                'TotalAmount' => (6 * $coke->Price) + (4 * $lays->Price),
                'OrderDate' => Carbon::now()->subDays(14),
                'Status' => 'Completed',
                'payment_method' => 'Credit/Debit Card',
                'shipping_address' => $user1->address,
            ]);
            OrderDetail::create([
                'OrderID' => $order1->OrderID,
                'PID' => $coke->PID,
                'Quantity' => 6,
                'Price' => $coke->Price,
                'Subtotal' => 6 * $coke->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order1->OrderID,
                'PID' => $lays->PID,
                'Quantity' => 4,
                'Price' => $lays->Price,
                'Subtotal' => 4 * $lays->Price,
            ]);
        }

        // Order 2 (7 days ago)
        if ($user2 && $milk && $donut && $watermelon) {
            $order2 = Order::create([
                'UserID' => $user2->id,
                'TotalAmount' => (4 * $milk->Price) + (3 * $donut->Price) + (1 * $watermelon->Price),
                'OrderDate' => Carbon::now()->subDays(7),
                'Status' => 'Completed',
                'payment_method' => 'Cash on Delivery',
                'shipping_address' => $user2->address,
            ]);
            OrderDetail::create([
                'OrderID' => $order2->OrderID,
                'PID' => $milk->PID,
                'Quantity' => 4,
                'Price' => $milk->Price,
                'Subtotal' => 4 * $milk->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order2->OrderID,
                'PID' => $donut->PID,
                'Quantity' => 3,
                'Price' => $donut->Price,
                'Subtotal' => 3 * $donut->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order2->OrderID,
                'PID' => $watermelon->PID,
                'Quantity' => 1,
                'Price' => $watermelon->Price,
                'Subtotal' => 1 * $watermelon->Price,
            ]);
        }

        // Order 3 (3 days ago)
        if ($user1 && $cream && $dove) {
            $order3 = Order::create([
                'UserID' => $user1->id,
                'TotalAmount' => (1 * $cream->Price) + (2 * $dove->Price),
                'OrderDate' => Carbon::now()->subDays(3),
                'Status' => 'Completed',
                'payment_method' => 'Online Banking',
                'shipping_address' => $user1->address,
            ]);
            OrderDetail::create([
                'OrderID' => $order3->OrderID,
                'PID' => $cream->PID,
                'Quantity' => 1,
                'Price' => $cream->Price,
                'Subtotal' => 1 * $cream->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order3->OrderID,
                'PID' => $dove->PID,
                'Quantity' => 2,
                'Price' => $dove->Price,
                'Subtotal' => 2 * $dove->Price,
            ]);
        }

        // Order 4 (Today)
        if ($user2 && $banana && $pocky && $pringles) {
            $order4 = Order::create([
                'UserID' => $user2->id,
                'TotalAmount' => (3 * $banana->Price) + (4 * $pocky->Price) + (2 * $pringles->Price),
                'OrderDate' => Carbon::now(),
                'Status' => 'Completed',
                'payment_method' => 'Cash on Delivery',
                'shipping_address' => $user2->address,
            ]);
            OrderDetail::create([
                'OrderID' => $order4->OrderID,
                'PID' => $banana->PID,
                'Quantity' => 3,
                'Price' => $banana->Price,
                'Subtotal' => 3 * $banana->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order4->OrderID,
                'PID' => $pocky->PID,
                'Quantity' => 4,
                'Price' => $pocky->Price,
                'Subtotal' => 4 * $pocky->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order4->OrderID,
                'PID' => $pringles->PID,
                'Quantity' => 2,
                'Price' => $pringles->Price,
                'Subtotal' => 2 * $pringles->Price,
            ]);
        }
    }
}
