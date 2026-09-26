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

        // 3. Seed Exact 7 Categories matching user's image folders
        $categoriesData = [
            ['name' => 'Bakery', 'description' => 'Freshly baked artisan bread, croissants, donuts, and cakes', 'icon' => 'bi-basket'],
            ['name' => 'Drinks', 'description' => 'Refreshing carbonated soft drinks, energy drinks, and sodas', 'icon' => 'bi-cup-straw'],
            ['name' => 'Fruit', 'description' => 'Farm-fresh organic fruits, seasonal berries, melons, and citrus', 'icon' => 'bi-apple'],
            ['name' => 'Milk & Dairy', 'description' => 'Pure pasteurized cow milk, oat milk, yogurts, and malt drinks', 'icon' => 'bi-egg-fried'],
            ['name' => 'Personal Care', 'description' => 'Soaps, body wash, shampoos, conditioners, and body lotions', 'icon' => 'bi-heart-pulse'],
            ['name' => 'Skincare', 'description' => 'Korean skincare serums, moisturizers, sunscreens, and creams', 'icon' => 'bi-stars'],
            ['name' => 'Snacks', 'description' => 'Crispy chips, potato crisps, chocolate bars, gummies, and cookies', 'icon' => 'bi-cookie'],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $cat = Category::firstOrCreate(['name' => $c['name']], $c);
            $categories[$c['name']] = $cat;
        }

        // 4. Seed All 59 Products matching the exact images in public/images/
        $allProducts = [
            // ==================== BAKERY (8 Items) ====================
            [
                'PName' => 'Glazed Chocolate Donuts (2-Pack)',
                'CatID' => $categories['Bakery']->CatID,
                'Qty' => 20,
                'MinStock' => 8,
                'Price' => 3.50,
                'ExpiredDate' => Carbon::now()->addDays(5),
                'image' => 'images/bakery/Chocolate-Donuts.jpg',
                'description' => 'Soft fluffy ring donuts coated in rich Belgian dark chocolate glaze.',
            ],
            [
                'PName' => 'Dark Chocolate Truffle Cake 350g',
                'CatID' => $categories['Bakery']->CatID,
                'Qty' => 12,
                'MinStock' => 5,
                'Price' => 6.99,
                'ExpiredDate' => Carbon::now()->addDays(6),
                'image' => 'images/bakery/Chocolate-truffle.jpg',
                'description' => 'Decadent multi-layered chocolate truffle cake dusted with cocoa powder.',
            ],
            [
                'PName' => 'Artisanal Cinnamon Swirl Loaf 450g',
                'CatID' => $categories['Bakery']->CatID,
                'Qty' => 15,
                'MinStock' => 6,
                'Price' => 4.80,
                'ExpiredDate' => Carbon::now()->addDays(4),
                'image' => 'images/bakery/cinnamon-bread.jpg',
                'description' => 'Aromatic oven-baked sourdough bread swirled with cinnamon sugar and brown butter.',
            ],
            [
                'PName' => 'Chunky Chocolate Chip Cookies (6-Pack)',
                'CatID' => $categories['Bakery']->CatID,
                'Qty' => 25,
                'MinStock' => 10,
                'Price' => 3.99,
                'ExpiredDate' => Carbon::now()->addDays(14),
                'image' => 'images/bakery/cookie.jpg',
                'description' => 'Crispy on the edges, chewy in the center cookies packed with semi-sweet chocolate morsels.',
            ],
            [
                'PName' => 'French All-Butter Croissant (2-Pack)',
                'CatID' => $categories['Bakery']->CatID,
                'Qty' => 3, // LOW STOCK
                'MinStock' => 8,
                'Price' => 3.25,
                'ExpiredDate' => Carbon::now()->addDays(3),
                'image' => 'images/bakery/croissant.jpg',
                'description' => 'Traditional flaky French pastries laminated with 100% pure Normandy churned butter.',
            ],
            [
                'PName' => 'Japanese Matcha Green Tea Cake Slice',
                'CatID' => $categories['Bakery']->CatID,
                'Qty' => 8,
                'MinStock' => 5,
                'Price' => 4.50,
                'ExpiredDate' => Carbon::now()->subDays(1), // EXPIRED TEST
                'image' => 'images/bakery/matcha-cake-slide.jpg',
                'description' => 'Authentic Uji ceremonial matcha infused sponge cake layered with sweet cream.',
            ],
            [
                'PName' => 'Oreo Cream Tiramisu Dessert Cup',
                'CatID' => $categories['Bakery']->CatID,
                'Qty' => 18,
                'MinStock' => 6,
                'Price' => 4.25,
                'ExpiredDate' => Carbon::now()->addDays(7), // EXPIRING SOON
                'image' => 'images/bakery/oreo-tiramisu.jpg',
                'description' => 'Espresso-soaked cookies layered with velvety mascarpone and crushed Oreo crumbs.',
            ],
            [
                'PName' => 'Assorted Gourmet Trio Donuts (3-Pack)',
                'CatID' => $categories['Bakery']->CatID,
                'Qty' => 14,
                'MinStock' => 5,
                'Price' => 4.99,
                'ExpiredDate' => Carbon::now()->addDays(4),
                'image' => 'images/bakery/trio-donuts.jpg',
                'description' => 'Trio of chocolate iced, strawberry sprinkle, and sugar glaze artisan donuts.',
            ],

            // ==================== DRINKS (6 Items) ====================
            [
                'PName' => 'Coca-Cola Original Taste 330ml Can',
                'CatID' => $categories['Drinks']->CatID,
                'Qty' => 120,
                'MinStock' => 25,
                'Price' => 1.25,
                'ExpiredDate' => Carbon::now()->addMonths(9),
                'image' => 'images/drinks/Coca-Cola.jpg',
                'description' => 'The world-famous classic sparkling refreshing cola soda.',
            ],
            [
                'PName' => 'Fanta Strawberry Sparkling Soda 330ml',
                'CatID' => $categories['Drinks']->CatID,
                'Qty' => 60,
                'MinStock' => 15,
                'Price' => 1.25,
                'ExpiredDate' => Carbon::now()->addMonths(8),
                'image' => 'images/drinks/Fanta-Strawberry.jpg',
                'description' => 'Bright, bubbly, and fruity strawberry flavored carbonated soft drink.',
            ],
            [
                'PName' => 'Monster Energy Original Green 355ml',
                'CatID' => $categories['Drinks']->CatID,
                'Qty' => 45,
                'MinStock' => 12,
                'Price' => 2.75,
                'ExpiredDate' => Carbon::now()->addMonths(12),
                'image' => 'images/drinks/Monster-Energy.jpg',
                'description' => 'Tear into a can of the meanest energy drink on the planet with B-vitamins and taurine.',
            ],
            [
                'PName' => 'Sprite Lemon-Lime Refreshing Soda 330ml',
                'CatID' => $categories['Drinks']->CatID,
                'Qty' => 80,
                'MinStock' => 20,
                'Price' => 1.25,
                'ExpiredDate' => Carbon::now()->addMonths(10),
                'image' => 'images/drinks/Sprite.jpg',
                'description' => 'Crisp, refreshing 100% natural lemon-lime caffeine-free soda.',
            ],
            [
                'PName' => 'Pepsi Cola Classic Blue Can 330ml',
                'CatID' => $categories['Drinks']->CatID,
                'Qty' => 5, // LOW STOCK
                'MinStock' => 20,
                'Price' => 1.20,
                'ExpiredDate' => Carbon::now()->addMonths(8),
                'image' => 'images/drinks/pepsi.jpg',
                'description' => 'Bold and refreshing cola beverage crafted for ultimate satisfaction.',
            ],
            [
                'PName' => 'Wurks Energy Boost Drink 250ml',
                'CatID' => $categories['Drinks']->CatID,
                'Qty' => 30,
                'MinStock' => 10,
                'Price' => 1.99,
                'ExpiredDate' => Carbon::now()->subDays(3), // EXPIRED TEST
                'image' => 'images/drinks/wurks.jpg',
                'description' => 'Intense performance energy beverage packed with electrolytes and caffeine.',
            ],

            // ==================== FRUIT (10 Items) ====================
            [
                'PName' => 'Golden Sweet Tropical Pineapple',
                'CatID' => $categories['Fruit']->CatID,
                'Qty' => 22,
                'MinStock' => 8,
                'Price' => 3.99,
                'ExpiredDate' => Carbon::now()->addDays(10),
                'image' => 'images/fruit/Pinapple.jpg',
                'description' => 'Naturally sun-ripened golden pineapple bursting with sweet tropical juice.',
            ],
            [
                'PName' => 'Whole Sweet Seedless Watermelon',
                'CatID' => $categories['Fruit']->CatID,
                'Qty' => 15,
                'MinStock' => 6,
                'Price' => 5.49,
                'ExpiredDate' => Carbon::now()->addDays(12),
                'image' => 'images/fruit/Watermelon.jpg',
                'description' => 'Hydrating, crisp, and deep-red sweet seedless whole watermelon.',
            ],
            [
                'PName' => 'Fresh Hass Ripe Avocado',
                'CatID' => $categories['Fruit']->CatID,
                'Qty' => 35,
                'MinStock' => 10,
                'Price' => 1.80,
                'ExpiredDate' => Carbon::now()->addDays(8),
                'image' => 'images/fruit/avocado.jpg',
                'description' => 'Creamy premium Hass avocado rich in healthy monounsaturated omega fats.',
            ],
            [
                'PName' => 'Organic Cavendish Bananas (1kg)',
                'CatID' => $categories['Fruit']->CatID,
                'Qty' => 40,
                'MinStock' => 12,
                'Price' => 2.49,
                'ExpiredDate' => Carbon::now()->addDays(7),
                'image' => 'images/fruit/banana.jpg',
                'description' => 'Fresh cluster of potassium-packed golden yellow Cavendish bananas.',
            ],
            [
                'PName' => 'Vibrant Red Pitaya Dragonfruit',
                'CatID' => $categories['Fruit']->CatID,
                'Qty' => 18,
                'MinStock' => 6,
                'Price' => 3.85,
                'ExpiredDate' => Carbon::now()->addDays(9),
                'image' => 'images/fruit/dragonfruit.jpg',
                'description' => 'Exotic magenta-fleshed dragonfruit packed with antioxidants and fiber.',
            ],
            [
                'PName' => 'Seedless Sweet Crimson Grapes 500g',
                'CatID' => $categories['Fruit']->CatID,
                'Qty' => 28,
                'MinStock' => 10,
                'Price' => 3.99,
                'ExpiredDate' => Carbon::now()->addDays(12),
                'image' => 'images/fruit/grape.jpg',
                'description' => 'Crisp, bite-sized seedless red grapes bursting with natural sweetness.',
            ],
            [
                'PName' => 'Green Zesty Kiwi Fruit (Pack of 4)',
                'CatID' => $categories['Fruit']->CatID,
                'Qty' => 4, // LOW STOCK
                'MinStock' => 10,
                'Price' => 2.99,
                'ExpiredDate' => Carbon::now()->addDays(14),
                'image' => 'images/fruit/kiwi.jpg',
                'description' => 'Tangy-sweet fresh kiwi fruits loaded with Vitamin C.',
            ],
            [
                'PName' => 'Fresh Sweet Honey Lychee 500g',
                'CatID' => $categories['Fruit']->CatID,
                'Qty' => 16,
                'MinStock' => 6,
                'Price' => 4.80,
                'ExpiredDate' => Carbon::now()->addDays(8),
                'image' => 'images/fruit/lychee.jpg',
                'description' => 'Juicy translucent lychees with a floral aroma and delicate sweet taste.',
            ],
            [
                'PName' => 'Juicy Fresh Navel Oranges (1kg Bag)',
                'CatID' => $categories['Fruit']->CatID,
                'Qty' => 50,
                'MinStock' => 15,
                'Price' => 3.50,
                'ExpiredDate' => Carbon::now()->addDays(16),
                'image' => 'images/fruit/orange.jpg',
                'description' => 'Plump, seedless California navel oranges easy to peel and perfect for snacking.',
            ],
            [
                'PName' => 'Fresh Farm Strawberries 250g Clamshell',
                'CatID' => $categories['Fruit']->CatID,
                'Qty' => 2, // LOW STOCK
                'MinStock' => 8,
                'Price' => 4.25,
                'ExpiredDate' => Carbon::now()->addDays(5),
                'image' => 'images/fruit/strawberry.jpg',
                'description' => 'Locally harvested bright red strawberries bursting with summer flavor.',
            ],

            // ==================== MILK & DAIRY (6 Items) ====================
            [
                'PName' => 'Cowhead Pure Fresh Whole Milk 1L',
                'CatID' => $categories['Milk & Dairy']->CatID,
                'Qty' => 35,
                'MinStock' => 10,
                'Price' => 3.49,
                'ExpiredDate' => Carbon::now()->addMonths(4),
                'image' => 'images/milk/Cowhead-Milk.jpg',
                'description' => '100% pure premium Australian dairy milk rich in calcium and natural vitamin D.',
            ],
            [
                'PName' => 'Dutch Mill Probiotic Yogurt Milk 400ml',
                'CatID' => $categories['Milk & Dairy']->CatID,
                'Qty' => 28,
                'MinStock' => 10,
                'Price' => 2.25,
                'ExpiredDate' => Carbon::now()->addDays(20), // EXPIRING SOON
                'image' => 'images/milk/Milk-Yogurt.jpg',
                'description' => 'Refreshing cultured drinking yogurt containing beneficial active probiotic cultures.',
            ],
            [
                'PName' => 'Oatside Barista Blend Oat Milk 1L',
                'CatID' => $categories['Milk & Dairy']->CatID,
                'Qty' => 24,
                'MinStock' => 8,
                'Price' => 4.20,
                'ExpiredDate' => Carbon::now()->addMonths(6),
                'image' => 'images/milk/Oat-Milk.jpg',
                'description' => 'Creamy plant-based dairy-free oat milk specially crafted for coffees and cereal.',
            ],
            [
                'PName' => 'So Natural Strawberry Pink Milk 1L',
                'CatID' => $categories['Milk & Dairy']->CatID,
                'Qty' => 18,
                'MinStock' => 6,
                'Price' => 3.65,
                'ExpiredDate' => Carbon::now()->addMonths(5),
                'image' => 'images/milk/SO-Natural-Pink-Milk.jpg',
                'description' => 'Delicious smooth Australian milk infused with ripe strawberry essence.',
            ],
            [
                'PName' => 'So Natural Australian Full Cream Milk 1L',
                'CatID' => $categories['Milk & Dairy']->CatID,
                'Qty' => 40,
                'MinStock' => 12,
                'Price' => 3.49,
                'ExpiredDate' => Carbon::now()->addMonths(5),
                'image' => 'images/milk/So-Natural-White-Milk.jpg',
                'description' => 'Pasteurized full cream Australian fresh milk for strong bones and teeth.',
            ],
            [
                'PName' => 'Nestle Milo Active-Go Chocolate Malt 1L',
                'CatID' => $categories['Milk & Dairy']->CatID,
                'Qty' => 3, // LOW STOCK
                'MinStock' => 10,
                'Price' => 3.85,
                'ExpiredDate' => Carbon::now()->addMonths(7),
                'image' => 'images/milk/milo.jpg',
                'description' => 'The champion energy chocolate malt milk drink enriched with Protomalt and iron.',
            ],

            // ==================== PERSONAL CARE (10 Items) ====================
            [
                'PName' => 'Dove Restoring Coconut Butter Body Wash 500ml',
                'CatID' => $categories['Personal Care']->CatID,
                'Qty' => 25,
                'MinStock' => 8,
                'Price' => 6.99,
                'ExpiredDate' => Carbon::now()->addYears(2),
                'image' => 'images/personal care/Dove-Body-Wash-Coconut.jpg',
                'description' => 'Nourishing body wash infused with natural coconut butter and cocoa butter.',
            ],
            [
                'PName' => 'Dove Original 48h Antiperspirant Deodorant Stick',
                'CatID' => $categories['Personal Care']->CatID,
                'Qty' => 30,
                'MinStock' => 10,
                'Price' => 4.50,
                'ExpiredDate' => Carbon::now()->addYears(2),
                'image' => 'images/personal care/Dove-Original-Stick.jpg',
                'description' => 'Provides 48-hour odor and sweat protection with 1/4 moisturizing cream.',
            ],
            [
                'PName' => 'Dove Sakura Blossom Glow Body Wash 500ml',
                'CatID' => $categories['Personal Care']->CatID,
                'Qty' => 20,
                'MinStock' => 8,
                'Price' => 7.20,
                'ExpiredDate' => Carbon::now()->addYears(2),
                'image' => 'images/personal care/Dove-Sakura-Body-Wash.jpg',
                'description' => 'Delicate Japanese cherry blossom scent with skin-brightening moisturizers.',
            ],
            [
                'PName' => 'Dove Pomegranate Seeds & Shea Exfoliating Scrub',
                'CatID' => $categories['Personal Care']->CatID,
                'Qty' => 18,
                'MinStock' => 6,
                'Price' => 6.49,
                'ExpiredDate' => Carbon::now()->addYears(2),
                'image' => 'images/personal care/Dove-Scrub.jpg',
                'description' => 'Gentle body polishing scrub buffing away dry skin for silky smooth touch.',
            ],
            [
                'PName' => 'Enchanteur Romantic Perfumed Shower Gel 550ml',
                'CatID' => $categories['Personal Care']->CatID,
                'Qty' => 22,
                'MinStock' => 8,
                'Price' => 5.80,
                'ExpiredDate' => Carbon::now()->addYears(2),
                'image' => 'images/personal care/Enchanteur-Perfumed-Shower-Gel.jpg',
                'description' => 'Luxury French fine fragrance shower gel scented with Bulgarian rose and jasmine.',
            ],
            [
                'PName' => 'Lux Velvet Jasmine Beauty Bar Soap (3-Pack)',
                'CatID' => $categories['Personal Care']->CatID,
                'Qty' => 40,
                'MinStock' => 12,
                'Price' => 2.99,
                'ExpiredDate' => Carbon::now()->addYears(2),
                'image' => 'images/personal care/Lux.jpg',
                'description' => 'Rich cleansing soap bars infused with SilkEssence and natural floral oils.',
            ],
            [
                'PName' => 'Pelican For Back Medicated Herbal Soap 135g',
                'CatID' => $categories['Personal Care']->CatID,
                'Qty' => 2, // LOW STOCK
                'MinStock' => 8,
                'Price' => 4.95,
                'ExpiredDate' => Carbon::now()->addYears(2),
                'image' => 'images/personal care/Pelican-Soap.jpg',
                'description' => 'Japanese charcoal and mud soap specially formulated to combat acne and clarify pores.',
            ],
            [
                'PName' => 'Sunsilk Stunning Black Shine Shampoo 450ml',
                'CatID' => $categories['Personal Care']->CatID,
                'Qty' => 26,
                'MinStock' => 8,
                'Price' => 5.25,
                'ExpiredDate' => Carbon::now()->addYears(2),
                'image' => 'images/personal care/Shampoo-Sunsilk-Black.jpg',
                'description' => 'Formulated with Amla Pearl complex to revitalize dark locks with mirror-like shine.',
            ],
            [
                'PName' => 'Sunsilk Smooth & Manageable Conditioner 320ml',
                'CatID' => $categories['Personal Care']->CatID,
                'Qty' => 20,
                'MinStock' => 8,
                'Price' => 4.99,
                'ExpiredDate' => Carbon::now()->addYears(2),
                'image' => 'images/personal care/Sunsilk-Conditioner.jpg',
                'description' => 'Infused with 5 natural oils for all-day frizz-free and silky manageable hair.',
            ],
            [
                'PName' => 'Vaseline Healthy Bright UV Extra Lotion 330ml',
                'CatID' => $categories['Personal Care']->CatID,
                'Qty' => 15,
                'MinStock' => 6,
                'Price' => 6.75,
                'ExpiredDate' => Carbon::now()->addMonths(18),
                'image' => 'images/personal care/Vaseline-Healthy-Bright.jpg',
                'description' => 'Lightweight serum lotion offering 10x active niacinamide and broad-spectrum UV filters.',
            ],

            // ==================== SKINCARE (6 Items) ====================
            [
                'PName' => 'Anua Peach 77% Niacinamide Enriched Cream 50ml',
                'CatID' => $categories['Skincare']->CatID,
                'Qty' => 14,
                'MinStock' => 5,
                'Price' => 18.50,
                'ExpiredDate' => Carbon::now()->addMonths(18),
                'image' => 'images/skincare/Anu- Peach-Niacinamide-Cream.jpg',
                'description' => 'Gel-cream enriched with fermented peach extract and niacinamide for glass skin glow.',
            ],
            [
                'PName' => 'Anua Niacinamide 10% + TXA 4% Dark Spot Serum 30ml',
                'CatID' => $categories['Skincare']->CatID,
                'Qty' => 20,
                'MinStock' => 6,
                'Price' => 16.99,
                'ExpiredDate' => Carbon::now()->addMonths(18),
                'image' => 'images/skincare/Anua-Niacinamide-Serum.jpg',
                'description' => 'Potent serum targeting hyperpigmentation, acne scars, and uneven skin tone.',
            ],
            [
                'PName' => 'Beauty of Joseon Dynasty Royal Cream 50ml',
                'CatID' => $categories['Skincare']->CatID,
                'Qty' => 16,
                'MinStock' => 5,
                'Price' => 19.99,
                'ExpiredDate' => Carbon::now()->addMonths(20),
                'image' => 'images/skincare/Beauty-of-Joseon-Dynasty-Cream.jpg',
                'description' => 'Luxurious Korean Hanbang formulation containing ginseng root water and rice bran.',
            ],
            [
                'PName' => 'CeraVe Moisturising Cream for Dry Skin 454g',
                'CatID' => $categories['Skincare']->CatID,
                'Qty' => 25,
                'MinStock' => 8,
                'Price' => 17.80,
                'ExpiredDate' => Carbon::now()->addYears(2),
                'image' => 'images/skincare/CeraVe-Moisturising-Cream.jpg',
                'description' => 'Dermatologist recommended barrier-restoring cream with 3 essential ceramides.',
            ],
            [
                'PName' => 'TOCOBO Cotton Soft Sun Stick SPF50+ PA++++ 19g',
                'CatID' => $categories['Skincare']->CatID,
                'Qty' => 2, // LOW STOCK
                'MinStock' => 6,
                'Price' => 13.99,
                'ExpiredDate' => Carbon::now()->addMonths(16),
                'image' => 'images/skincare/TOCOBO.jpg',
                'description' => 'Velvety matte chemical sun stick absorbing excess sebum with zero white cast.',
            ],
            [
                'PName' => 'Medicube PDRN Pink Peptide Glowing Serum 30ml',
                'CatID' => $categories['Skincare']->CatID,
                'Qty' => 12,
                'MinStock' => 4,
                'Price' => 24.50,
                'ExpiredDate' => Carbon::now()->subDays(5), // EXPIRED TEST
                'image' => 'images/skincare/medicube-pdrn-serum.jpg',
                'description' => 'High-performance salmon DNA PDRN serum promoting cellular elasticity and glass radiance.',
            ],

            // ==================== SNACKS (13 Items) ====================
            [
                'PName' => 'Fruity Gummy Bear Sweet Treats 150g',
                'CatID' => $categories['Snacks']->CatID,
                'Qty' => 35,
                'MinStock' => 10,
                'Price' => 2.10,
                'ExpiredDate' => Carbon::now()->addMonths(10),
                'image' => 'images/snacks/Gummy-Candy.jpg',
                'description' => 'Chewy multi-flavored gummy bears made with real concentrated fruit juice.',
            ],
            [
                'PName' => "Lay's Classic Salted Potato Chips 180g",
                'CatID' => $categories['Snacks']->CatID,
                'Qty' => 45,
                'MinStock' => 10,
                'Price' => 2.50,
                'ExpiredDate' => Carbon::now()->addMonths(6),
                'image' => "images/snacks/Lay's-Classic-Potato.jpg",
                'description' => 'Thinly sliced crispy farm-grown potatoes seasoned with pure sea salt.',
            ],
            [
                'PName' => "Lay's Flamin' Hot Dill Pickle Flavored Chips",
                'CatID' => $categories['Snacks']->CatID,
                'Qty' => 28,
                'MinStock' => 10,
                'Price' => 2.65,
                'ExpiredDate' => Carbon::now()->addMonths(6),
                'image' => "images/snacks/Lay's-Hot-Dill-Pickle.jpg",
                'description' => 'Tangy dill pickle flavor fused with fiery Flamin Hot chili pepper kick.',
            ],
            [
                'PName' => "Lay's Sour Cream & Onion Potato Chips 180g",
                'CatID' => $categories['Snacks']->CatID,
                'Qty' => 40,
                'MinStock' => 10,
                'Price' => 2.50,
                'ExpiredDate' => Carbon::now()->addMonths(6),
                'image' => "images/snacks/Lay's-Potato-Cream-Onion-Flavour.jpg",
                'description' => 'America favorite creamy sour cream and savory garden onion crunch.',
            ],
            [
                'PName' => "Post Oreo O's Crunchy Chocolate Cereal 311g",
                'CatID' => $categories['Snacks']->CatID,
                'Qty' => 22,
                'MinStock' => 8,
                'Price' => 5.20,
                'ExpiredDate' => Carbon::now()->addMonths(10),
                'image' => "images/snacks/Oreo-O's-Cereal.jpg",
                'description' => 'Delicious O-shaped chocolate cereal rings with sweet vanilla creme coating.',
            ],
            [
                'PName' => 'Nestle KitKat Ruby Cocoa Pink Wafers (Pack of 4)',
                'CatID' => $categories['Snacks']->CatID,
                'Qty' => 18,
                'MinStock' => 6,
                'Price' => 3.75,
                'ExpiredDate' => Carbon::now()->addMonths(8),
                'image' => 'images/snacks/Pink-KitKat.jpg',
                'description' => 'Crispy wafer fingers enrobed in naturally fruity ruby cacao bean chocolate.',
            ],
            [
                'PName' => 'Pringles Sabor Original Stackable Crisps 149g',
                'CatID' => $categories['Snacks']->CatID,
                'Qty' => 32,
                'MinStock' => 10,
                'Price' => 2.85,
                'ExpiredDate' => Carbon::now()->addMonths(9),
                'image' => 'images/snacks/Pringles-Sabor-Original.jpg',
                'description' => 'Iconic hyperbolic paraboloid potato crisps seasoned with savory salt in a can.',
            ],
            [
                'PName' => 'Sweet & Tangy Soft Chewy Fruit Drops 180g',
                'CatID' => $categories['Snacks']->CatID,
                'Qty' => 30,
                'MinStock' => 10,
                'Price' => 2.30,
                'ExpiredDate' => Carbon::now()->addMonths(10),
                'image' => 'images/snacks/Soft& hewy-Gummy-Candy.jpg',
                'description' => 'Assorted soft bite gummies dusted with micro fine crystal sour sugar.',
            ],
            [
                'PName' => "M&M's Milk Chocolate Candies Sharing Pouch",
                'CatID' => $categories['Snacks']->CatID,
                'Qty' => 40,
                'MinStock' => 12,
                'Price' => 2.99,
                'ExpiredDate' => Carbon::now()->addMonths(12),
                'image' => 'images/snacks/m&m.jpg',
                'description' => 'Real milk chocolate covered in colorful crisp candy shells.',
            ],
            [
                'PName' => 'Mentos Fresh Mint Chewy Dragees Roll',
                'CatID' => $categories['Snacks']->CatID,
                'Qty' => 60,
                'MinStock' => 15,
                'Price' => 1.10,
                'ExpiredDate' => Carbon::now()->addMonths(18),
                'image' => 'images/snacks/mentos.jpg',
                'description' => 'Crispy on the outside, delightfully chewy and minty on the inside.',
            ],
            [
                'PName' => 'Barcel Mini Takis Fuego Hot Chili Corn Chips',
                'CatID' => $categories['Snacks']->CatID,
                'Qty' => 3, // LOW STOCK
                'MinStock' => 12,
                'Price' => 1.99,
                'ExpiredDate' => Carbon::now()->addMonths(8),
                'image' => 'images/snacks/mini-takis.jpg',
                'description' => 'Mini rolled tortilla chips packed with spicy hot chili pepper and lime.',
            ],
            [
                'PName' => 'Glico Pocky Classic Chocolate Cream Sticks',
                'CatID' => $categories['Snacks']->CatID,
                'Qty' => 50,
                'MinStock' => 15,
                'Price' => 1.85,
                'ExpiredDate' => Carbon::now()->addMonths(12),
                'image' => 'images/snacks/pocky.jpg',
                'description' => 'Crispy biscuit pretzel sticks dipped in rich chocolate confectionery cream.',
            ],
            [
                'PName' => 'Takis Waves Fuego Spicy Wavy Potato Chips',
                'CatID' => $categories['Snacks']->CatID,
                'Qty' => 24,
                'MinStock' => 8,
                'Price' => 3.10,
                'ExpiredDate' => Carbon::now()->addMonths(7),
                'image' => 'images/snacks/takis-hechos-ricos.jpg',
                'description' => 'Extra-wavy crunchy potato chips drenched in explosive hot chili lime seasoning.',
            ],
        ];

        $seededProducts = [];
        foreach ($allProducts as $pData) {
            $prod = Product::updateOrCreate(
                ['PName' => $pData['PName']],
                $pData
            );
            $seededProducts[] = $prod;
        }

        // 5. Seed Realistic Orders for Analytics & Reports
        if (Order::count() === 0) {
            // Order 1 (14 days ago)
            $order1 = Order::create([
                'UserID' => $user1->id,
                'TotalAmount' => 18.75,
                'OrderDate' => Carbon::now()->subDays(14),
                'Status' => 'Completed',
                'payment_method' => 'Credit/Debit Card',
                'shipping_address' => $user1->address,
            ]);
            OrderDetail::create([
                'OrderID' => $order1->OrderID,
                'PID' => $seededProducts[8]->PID, // Coca Cola
                'Quantity' => 6,
                'Price' => $seededProducts[8]->Price,
                'Subtotal' => 6 * $seededProducts[8]->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order1->OrderID,
                'PID' => $seededProducts[47]->PID, // Lay's Classic
                'Quantity' => 4,
                'Price' => $seededProducts[47]->Price,
                'Subtotal' => 4 * $seededProducts[47]->Price,
            ]);

            // Order 2 (7 days ago)
            $order2 = Order::create([
                'UserID' => $user2->id,
                'TotalAmount' => 34.20,
                'OrderDate' => Carbon::now()->subDays(7),
                'Status' => 'Completed',
                'payment_method' => 'Cash on Delivery',
                'shipping_address' => $user2->address,
            ]);
            OrderDetail::create([
                'OrderID' => $order2->OrderID,
                'PID' => $seededProducts[24]->PID, // Cowhead Milk
                'Quantity' => 4,
                'Price' => $seededProducts[24]->Price,
                'Subtotal' => 4 * $seededProducts[24]->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order2->OrderID,
                'PID' => $seededProducts[0]->PID, // Donuts
                'Quantity' => 3,
                'Price' => $seededProducts[0]->Price,
                'Subtotal' => 3 * $seededProducts[0]->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order2->OrderID,
                'PID' => $seededProducts[14]->PID, // Watermelon
                'Quantity' => 1,
                'Price' => $seededProducts[14]->Price,
                'Subtotal' => 1 * $seededProducts[14]->Price,
            ]);

            // Order 3 (3 days ago)
            $order3 = Order::create([
                'UserID' => $user1->id,
                'TotalAmount' => 42.60,
                'OrderDate' => Carbon::now()->subDays(3),
                'Status' => 'Completed',
                'payment_method' => 'Online Banking',
                'shipping_address' => $user1->address,
            ]);
            OrderDetail::create([
                'OrderID' => $order3->OrderID,
                'PID' => $seededProducts[40]->PID, // Beauty of Joseon
                'Quantity' => 1,
                'Price' => $seededProducts[40]->Price,
                'Subtotal' => 1 * $seededProducts[40]->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order3->OrderID,
                'PID' => $seededProducts[30]->PID, // Dove Body Wash
                'Quantity' => 2,
                'Price' => $seededProducts[30]->Price,
                'Subtotal' => 2 * $seededProducts[30]->Price,
            ]);

            // Order 4 (Today)
            $order4 = Order::create([
                'UserID' => $user2->id,
                'TotalAmount' => 22.35,
                'OrderDate' => Carbon::now(),
                'Status' => 'Completed',
                'payment_method' => 'Cash on Delivery',
                'shipping_address' => $user2->address,
            ]);
            OrderDetail::create([
                'OrderID' => $order4->OrderID,
                'PID' => $seededProducts[17]->PID, // Bananas
                'Quantity' => 3,
                'Price' => $seededProducts[17]->Price,
                'Subtotal' => 3 * $seededProducts[17]->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order4->OrderID,
                'PID' => $seededProducts[57]->PID, // Pocky
                'Quantity' => 4,
                'Price' => $seededProducts[57]->Price,
                'Subtotal' => 4 * $seededProducts[57]->Price,
            ]);
            OrderDetail::create([
                'OrderID' => $order4->OrderID,
                'PID' => $seededProducts[52]->PID, // Pringles
                'Quantity' => 2,
                'Price' => $seededProducts[52]->Price,
                'Subtotal' => 2 * $seededProducts[52]->Price,
            ]);
        }
    }
}
