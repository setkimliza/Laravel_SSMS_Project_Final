<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Staff Accounts (Admin & Stock)
        Staff::firstOrCreate(
            ['UserName' => 'admin'],
            [
                'Password' => Hash::make('password123'),
                'Role' => 'Admin',
            ]
        );

        Staff::firstOrCreate(
            ['UserName' => 'stock'],
            [
                'Password' => Hash::make('password123'),
                'Role' => 'Stock',
            ]
        );

        // 2. Seed Customer Users
        $user1 = User::firstOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Doe',
                'phone' => '+1 (555) 234-5678',
                'address' => '742 Evergreen Terrace, Springfield',
                'password' => Hash::make('password123'),
            ]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'sarah@example.com'],
            [
                'name' => 'Sarah Connor',
                'phone' => '+1 (555) 876-5432',
                'address' => '101 Cyberdyne Way, Los Angeles, CA',
                'password' => Hash::make('password123'),
            ]
        );

        // 3. Seed 10 Supermarket Categories
        $categoriesData = [
            ['name' => 'Snacks', 'description' => 'Crispy chips, roasted nuts, crackers, and biscuits', 'icon' => 'bi-cookie'],
            ['name' => 'Drinks', 'description' => 'Soft drinks, bottled spring water, energy drinks, and natural juices', 'icon' => 'bi-cup-straw'],
            ['name' => 'Milk & Dairy', 'description' => 'Fresh whole milk, cheeses, yogurts, and butter', 'icon' => 'bi-egg-fried'],
            ['name' => 'Instant Food', 'description' => 'Quick noodles, instant soups, oatmeal, and ready meals', 'icon' => 'bi-lightning-charge'],
            ['name' => 'Canned Food', 'description' => 'Canned tuna, baked beans, sweet corn, and soups', 'icon' => 'bi-archive'],
            ['name' => 'Personal Care', 'description' => 'Shampoo, soaps, oral hygiene, and skincare essentials', 'icon' => 'bi-heart-pulse'],
            ['name' => 'Household', 'description' => 'Cleaning liquids, laundry detergent, wipes, and paper towels', 'icon' => 'bi-house-check'],
            ['name' => 'Bakery', 'description' => 'Freshly baked artisanal bread, baguettes, and croissants', 'icon' => 'bi-basket'],
            ['name' => 'Frozen Food', 'description' => 'Frozen pizza, ice creams, berries, and dumplings', 'icon' => 'bi-snow'],
            ['name' => 'Grocery', 'description' => 'Aromatic jasmine rice, olive oil, organic pasta, and spices', 'icon' => 'bi-cart4'],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $cat = Category::firstOrCreate(['name' => $c['name']], $c);
            $categories[$c['name']] = $cat;
        }

        // 4. Seed Comprehensive Products with diverse stock and expiry statuses
        $productsData = [
            // Snacks
            [
                'PName' => 'Lays Classic Potato Chips 180g',
                'CatID' => $categories['Snacks']->CatID,
                'Qty' => 45,
                'MinStock' => 10,
                'Price' => 2.50,
                'ExpiredDate' => Carbon::now()->addMonths(6),
                'description' => 'Crispy and savory thinly sliced potato chips sprinkled with salt.',
            ],
            [
                'PName' => 'Doritos Nacho Cheese 200g',
                'CatID' => $categories['Snacks']->CatID,
                'Qty' => 3, // LOW STOCK test
                'MinStock' => 10,
                'Price' => 2.99,
                'ExpiredDate' => Carbon::now()->addMonths(4),
                'description' => 'Crunchy tortilla chips packed with bold nacho cheese flavor.',
            ],
            [
                'PName' => 'Oreo Double Stuf Cookies 300g',
                'CatID' => $categories['Snacks']->CatID,
                'Qty' => 28,
                'MinStock' => 12,
                'Price' => 3.49,
                'ExpiredDate' => Carbon::now()->addMonths(8),
                'description' => 'Chocolate sandwich cookies with double vanilla creme filling.',
            ],

            // Drinks
            [
                'PName' => 'Coca-Cola Original 1.5L',
                'CatID' => $categories['Drinks']->CatID,
                'Qty' => 120,
                'MinStock' => 25,
                'Price' => 1.89,
                'ExpiredDate' => Carbon::now()->addMonths(9),
                'description' => 'The world-famous classic sparkling refreshing cola soda drink.',
            ],
            [
                'PName' => 'Evian Natural Mineral Water 1L',
                'CatID' => $categories['Drinks']->CatID,
                'Qty' => 85,
                'MinStock' => 20,
                'Price' => 1.99,
                'ExpiredDate' => Carbon::now()->addYears(1),
                'description' => 'Naturally pure spring mineral water directly from the French Alps.',
            ],
            [
                'PName' => 'Fresh Squeezed Orange Juice 1L',
                'CatID' => $categories['Drinks']->CatID,
                'Qty' => 8,
                'MinStock' => 10,
                'Price' => 4.20,
                'ExpiredDate' => Carbon::now()->subDays(3), // EXPIRED test
                'description' => '100% pure cold-pressed orange juice without added preservatives.',
            ],
            [
                'PName' => 'Red Bull Energy Drink 250ml',
                'CatID' => $categories['Drinks']->CatID,
                'Qty' => 60,
                'MinStock' => 15,
                'Price' => 2.25,
                'ExpiredDate' => Carbon::now()->addMonths(12),
                'description' => 'Vitalizes body and mind with taurine and B-group vitamins.',
            ],

            // Milk & Dairy
            [
                'PName' => 'Organic Valley Whole Milk 1 Gal',
                'CatID' => $categories['Milk & Dairy']->CatID,
                'Qty' => 15,
                'MinStock' => 10,
                'Price' => 4.80,
                'ExpiredDate' => Carbon::now()->addDays(7), // EXPIRING SOON test
                'description' => 'Pasteurized vitamin D whole milk sourced from pasture-raised cows.',
            ],
            [
                'PName' => 'Tillamook Sharp Cheddar Cheese 250g',
                'CatID' => $categories['Milk & Dairy']->CatID,
                'Qty' => 2, // LOW STOCK test
                'MinStock' => 8,
                'Price' => 5.49,
                'ExpiredDate' => Carbon::now()->addMonths(3),
                'description' => 'Aged naturally for over 9 months for rich, bold cheddar taste.',
            ],
            [
                'PName' => 'Chobani Greek Plain Yogurt 450g',
                'CatID' => $categories['Milk & Dairy']->CatID,
                'Qty' => 22,
                'MinStock' => 10,
                'Price' => 3.99,
                'ExpiredDate' => Carbon::now()->addDays(14),
                'description' => 'Thick and creamy strained Greek yogurt loaded with high protein.',
            ],

            // Instant Food
            [
                'PName' => 'Nongshim Shin Ramyun Gourmet Spicy 120g',
                'CatID' => $categories['Instant Food']->CatID,
                'Qty' => 90,
                'MinStock' => 20,
                'Price' => 1.45,
                'ExpiredDate' => Carbon::now()->addMonths(10),
                'description' => 'Famous rich beef bone broth instant noodle with fiery spices.',
            ],
            [
                'PName' => 'Kraft Macaroni & Cheese Dinner 206g',
                'CatID' => $categories['Instant Food']->CatID,
                'Qty' => 4, // LOW STOCK test
                'MinStock' => 15,
                'Price' => 1.99,
                'ExpiredDate' => Carbon::now()->addMonths(6),
                'description' => 'Classic comfort elbow macaroni drenched in gooey cheddar sauce.',
            ],

            // Canned Food
            [
                'PName' => 'Rio Mare Solid Light Tuna in Olive Oil 160g',
                'CatID' => $categories['Canned Food']->CatID,
                'Qty' => 50,
                'MinStock' => 15,
                'Price' => 3.85,
                'ExpiredDate' => Carbon::now()->addYears(2),
                'description' => 'Premium yellowfin solid tuna steak bathed in golden Italian olive oil.',
            ],
            [
                'PName' => 'Heinz Baked Beans in Tomato Sauce 415g',
                'CatID' => $categories['Canned Food']->CatID,
                'Qty' => 35,
                'MinStock' => 12,
                'Price' => 2.10,
                'ExpiredDate' => Carbon::now()->addYears(2),
                'description' => 'Tender haricot beans slow-cooked in a rich, tangy tomato herb sauce.',
            ],

            // Personal Care
            [
                'PName' => 'Dove Deep Moisture Body Wash 500ml',
                'CatID' => $categories['Personal Care']->CatID,
                'Qty' => 25,
                'MinStock' => 10,
                'Price' => 6.99,
                'ExpiredDate' => Carbon::now()->addYears(2),
                'description' => 'Nourishing microbiome gentle sulfate-free cleanser for smooth skin.',
            ],
            [
                'PName' => 'Colgate Total Clean Mint Toothpaste 150g',
                'CatID' => $categories['Personal Care']->CatID,
                'Qty' => 40,
                'MinStock' => 15,
                'Price' => 3.25,
                'ExpiredDate' => Carbon::now()->addMonths(18),
                'description' => '12-hour antibacterial defense against cavities, tartar and plaque.',
            ],

            // Household
            [
                'PName' => 'Tide Liquid Laundry Detergent 1.36L',
                'CatID' => $categories['Household']->CatID,
                'Qty' => 18,
                'MinStock' => 8,
                'Price' => 11.50,
                'ExpiredDate' => Carbon::now()->addYears(2),
                'description' => 'High-efficiency deep cleaning power lifting stubborn dirt and stains.',
            ],
            [
                'PName' => 'Palmolive Ultra Dishwashing Liquid 750ml',
                'CatID' => $categories['Household']->CatID,
                'Qty' => 30,
                'MinStock' => 10,
                'Price' => 3.75,
                'ExpiredDate' => Carbon::now()->addYears(2),
                'description' => 'Tough on kitchen grease while remaining soft on hands.',
            ],

            // Bakery
            [
                'PName' => 'Artisanal Sourdough Bread Loaf 500g',
                'CatID' => $categories['Bakery']->CatID,
                'Qty' => 12,
                'MinStock' => 5,
                'Price' => 4.50,
                'ExpiredDate' => Carbon::now()->addDays(4),
                'description' => 'Slow-fermented crusty sourdough with a tender, tangy crumb.',
            ],
            [
                'PName' => 'Golden Butter Croissants (4-Pack)',
                'CatID' => $categories['Bakery']->CatID,
                'Qty' => 1, // LOW STOCK
                'MinStock' => 6,
                'Price' => 4.99,
                'ExpiredDate' => Carbon::now()->subDays(1), // EXPIRED test
                'description' => 'Traditional flaky French croissants baked with pure European creamery butter.',
            ],

            // Frozen Food
            [
                'PName' => 'DiGiorno Rising Crust Four Cheese Pizza 800g',
                'CatID' => $categories['Frozen Food']->CatID,
                'Qty' => 20,
                'MinStock' => 8,
                'Price' => 8.99,
                'ExpiredDate' => Carbon::now()->addMonths(8),
                'description' => 'Crispy outside, tender inside crust topped with mozzarella and cheddar.',
            ],
            [
                'PName' => 'Haagen-Dazs Belgian Chocolate Ice Cream 460ml',
                'CatID' => $categories['Frozen Food']->CatID,
                'Qty' => 16,
                'MinStock' => 6,
                'Price' => 6.49,
                'ExpiredDate' => Carbon::now()->addMonths(6),
                'description' => 'Decadent chocolate ice cream loaded with rich fudge chocolate shavings.',
            ],

            // Grocery
            [
                'PName' => 'Royal Jasmine Fragrant Rice 5kg',
                'CatID' => $categories['Grocery']->CatID,
                'Qty' => 35,
                'MinStock' => 10,
                'Price' => 12.99,
                'ExpiredDate' => Carbon::now()->addMonths(18),
                'description' => 'Naturally scented long-grain premium Thai jasmine rice.',
            ],
            [
                'PName' => 'Bertolli Extra Virgin Olive Oil 750ml',
                'CatID' => $categories['Grocery']->CatID,
                'Qty' => 24,
                'MinStock' => 8,
                'Price' => 10.80,
                'ExpiredDate' => Carbon::now()->addMonths(14),
                'description' => 'First cold-pressed superior olive oil for dressings and sautéing.',
            ],
            [
                'PName' => 'Barilla Spaghetti No. 5 500g',
                'CatID' => $categories['Grocery']->CatID,
                'Qty' => 65,
                'MinStock' => 20,
                'Price' => 2.15,
                'ExpiredDate' => Carbon::now()->addYears(2),
                'description' => 'Authentic Italian durum wheat semolina non-GMO spaghetti pasta.',
            ],
        ];

        $seededProducts = [];
        foreach ($productsData as $item) {
            $p = Product::firstOrCreate(['PName' => $item['PName']], $item);
            $seededProducts[] = $p;
        }

        // 5. Seed Historical Orders for Sales Reporting and Analytics
        if (Order::count() === 0) {
            // Order 1 (2 weeks ago)
            $order1 = Order::create([
                'UserID' => $user1->id,
                'TotalAmount' => 25.18,
                'OrderDate' => Carbon::now()->subDays(14),
                'Status' => 'Completed',
                'payment_method' => 'Credit Card',
                'shipping_address' => $user1->address,
            ]);

            OrderDetail::create([
                'OrderID' => $order1->OrderID,
                'PID' => $seededProducts[0]->PID, // Lays
                'Quantity' => 4,
                'Price' => $seededProducts[0]->Price,
                'Subtotal' => 4 * $seededProducts[0]->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order1->OrderID,
                'PID' => $seededProducts[3]->PID, // Coca Cola
                'Quantity' => 8,
                'Price' => $seededProducts[3]->Price,
                'Subtotal' => 8 * $seededProducts[3]->Price,
            ]);

            // Order 2 (7 days ago)
            $order2 = Order::create([
                'UserID' => $user2->id,
                'TotalAmount' => 45.44,
                'OrderDate' => Carbon::now()->subDays(7),
                'Status' => 'Completed',
                'payment_method' => 'Cash on Delivery',
                'shipping_address' => $user2->address,
            ]);

            OrderDetail::create([
                'OrderID' => $order2->OrderID,
                'PID' => $seededProducts[3]->PID, // Coca Cola
                'Quantity' => 10,
                'Price' => $seededProducts[3]->Price,
                'Subtotal' => 10 * $seededProducts[3]->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order2->OrderID,
                'PID' => $seededProducts[20]->PID, // Pizza
                'Quantity' => 2,
                'Price' => $seededProducts[20]->Price,
                'Subtotal' => 2 * $seededProducts[20]->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order2->OrderID,
                'PID' => $seededProducts[21]->PID, // Ice cream
                'Quantity' => 1,
                'Price' => $seededProducts[21]->Price,
                'Subtotal' => 1 * $seededProducts[21]->Price,
            ]);

            // Order 3 (2 days ago)
            $order3 = Order::create([
                'UserID' => $user1->id,
                'TotalAmount' => 38.64,
                'OrderDate' => Carbon::now()->subDays(2),
                'Status' => 'Completed',
                'payment_method' => 'Credit Card',
                'shipping_address' => $user1->address,
            ]);

            OrderDetail::create([
                'OrderID' => $order3->OrderID,
                'PID' => $seededProducts[10]->PID, // Shin Ramyun
                'Quantity' => 6,
                'Price' => $seededProducts[10]->Price,
                'Subtotal' => 6 * $seededProducts[10]->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order3->OrderID,
                'PID' => $seededProducts[22]->PID, // Jasmine Rice
                'Quantity' => 2,
                'Price' => $seededProducts[22]->Price,
                'Subtotal' => 2 * $seededProducts[22]->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order3->OrderID,
                'PID' => $seededProducts[4]->PID, // Evian Water
                'Quantity' => 2,
                'Price' => $seededProducts[4]->Price,
                'Subtotal' => 2 * $seededProducts[4]->Price,
            ]);

            // Order 4 (Today)
            $order4 = Order::create([
                'UserID' => $user2->id,
                'TotalAmount' => 21.28,
                'OrderDate' => Carbon::now(),
                'Status' => 'Completed',
                'payment_method' => 'Cash on Delivery',
                'shipping_address' => $user2->address,
            ]);

            OrderDetail::create([
                'OrderID' => $order4->OrderID,
                'PID' => $seededProducts[2]->PID, // Oreo
                'Quantity' => 3,
                'Price' => $seededProducts[2]->Price,
                'Subtotal' => 3 * $seededProducts[2]->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order4->OrderID,
                'PID' => $seededProducts[16]->PID, // Tide
                'Quantity' => 1,
                'Price' => $seededProducts[16]->Price,
                'Subtotal' => 1 * $seededProducts[16]->Price,
            ]);
        }
    }
}
