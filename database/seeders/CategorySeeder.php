<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriesData = [
            ['name' => 'Bakery', 'description' => 'Freshly baked artisan bread, croissants, donuts, and cakes', 'icon' => 'bi-basket'],
            ['name' => 'Drinks', 'description' => 'Refreshing carbonated soft drinks, energy drinks, and sodas', 'icon' => 'bi-cup-straw'],
            ['name' => 'Fruit', 'description' => 'Farm-fresh organic fruits, seasonal berries, melons, and citrus', 'icon' => 'bi-apple'],
            ['name' => 'Milk & Dairy', 'description' => 'Pure pasteurized cow milk, oat milk, yogurts, and malt drinks', 'icon' => 'bi-egg-fried'],
            ['name' => 'Personal Care', 'description' => 'Soaps, body wash, shampoos, conditioners, and body lotions', 'icon' => 'bi-heart-pulse'],
            ['name' => 'Skincare', 'description' => 'Korean skincare serums, moisturizers, sunscreens, and creams', 'icon' => 'bi-stars'],
            ['name' => 'Snacks', 'description' => 'Crispy chips, potato crisps, chocolate bars, gummies, and cookies', 'icon' => 'bi-cookie'],
        ];

        foreach ($categoriesData as $c) {
            Category::firstOrCreate(['name' => $c['name']], $c);
        }
    }
}
