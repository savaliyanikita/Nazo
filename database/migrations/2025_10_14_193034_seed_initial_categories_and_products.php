<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     // ========== Categories ==========
    public function up(): void
    {
        if (DB::table('categories')->count() === 0) {
            DB::table('categories')->insert([
                ['id' => 1, 'name' => 'Teas', 'slug' => 'teas', 'image' => 'teas.jpg', 'created_at' => '2025-07-16 15:43:57', 'updated_at' => '2025-07-25 02:57:28'],
                ['id' => 2, 'name' => 'Raisins', 'slug' => 'raisins', 'image' => 'raisins.jpg', 'created_at' => '2025-07-16 15:43:57', 'updated_at' => '2025-07-25 02:57:28'],
                ['id' => 3, 'name' => 'Nuts', 'slug' => 'nuts', 'image' => 'nuts.jpg', 'created_at' => '2025-07-16 15:43:57', 'updated_at' => '2025-07-25 02:57:28'],
                ['id' => 4, 'name' => 'Seeds & Peas', 'slug' => 'seeds-peas', 'image' => 'seeds-peas.jpg', 'created_at' => '2025-07-16 15:43:57', 'updated_at' => '2025-07-25 02:57:28'],
                ['id' => 5, 'name' => 'Tropical Fruits', 'slug' => 'tropical-fruits', 'image' => 'tropical-fruits.jpg', 'created_at' => '2025-07-16 15:43:57', 'updated_at' => '2025-07-25 02:57:28'],
                ['id' => 6, 'name' => 'Plums & Berries', 'slug' => 'plums-berries', 'image' => 'plums-berries.jpg', 'created_at' => '2025-07-16 15:43:57', 'updated_at' => '2025-07-25 02:57:28'],
                ['id' => 7, 'name' => 'Figs', 'slug' => 'figs', 'image' => 'figs.jpg', 'created_at' => '2025-07-16 15:43:57', 'updated_at' => '2025-07-25 02:57:28'],
                ['id' => 8, 'name' => 'Halal Gummies / Candies', 'slug' => 'halal-gummies-candies', 'image' => 'halal-gummies-candies.jpg', 'created_at' => '2025-07-16 15:43:57', 'updated_at' => '2025-07-25 02:57:28'],
                ['id' => 9, 'name' => 'Fresh Dates', 'slug' => 'fresh-dates', 'image' => 'fresh-dates.jpg', 'created_at' => '2025-07-16 15:43:57', 'updated_at' => '2025-07-25 02:57:28'],
                ['id' => 10, 'name' => 'Pickles / Canned Foods', 'slug' => 'pickles-canned-foods', 'image' => 'pickles-canned-foods.jpg', 'created_at' => '2025-07-16 15:43:57', 'updated_at' => '2025-07-25 02:57:28'],
                ['id' => 11, 'name' => 'Oils', 'slug' => 'oils', 'image' => 'oils.jpg', 'created_at' => '2025-07-16 15:43:57', 'updated_at' => '2025-07-25 02:57:28'],
                ['id' => 12, 'name' => 'Spices', 'slug' => 'spices', 'image' => 'spices.jpg', 'created_at' => '2025-07-16 15:43:57', 'updated_at' => '2025-07-25 02:57:28'],
                ['id' => 13, 'name' => 'Dried Vegetables', 'slug' => 'dried-vegetables', 'image' => 'dried-vegetables.jpg', 'created_at' => '2025-07-16 15:43:57', 'updated_at' => '2025-07-25 02:57:28'],
                ['id' => 14, 'name' => 'Daals & Lentils', 'slug' => 'daals-lentils', 'image' => 'daals-lentils.jpg', 'created_at' => '2025-07-16 15:43:57', 'updated_at' => '2025-07-25 02:57:28'],
                ['id' => 15, 'name' => 'Rice', 'slug' => 'rice', 'image' => 'rice.jpg', 'created_at' => '2025-07-16 15:43:57', 'updated_at' => '2025-07-25 02:57:28'],
            ]);
        }

        // ========== Products ==========
        if (DB::table('products')->count() === 0) {
            DB::table('products')->insert([
                ['id' => 1, 'name' => 'Almonds', 'sku' => 'almonds', 'slug' => 'almonds', 'stock' => 0, 'category_id' => 3, 'created_at' => '2025-07-22 19:57:57', 'updated_at' => '2025-07-23 19:41:05'],
                ['id' => 2, 'name' => 'Cashews', 'sku' => 'cashews', 'slug' => 'cashews', 'stock' => 0, 'category_id' => 3, 'created_at' => '2025-07-23 19:47:01', 'updated_at' => '2025-07-23 19:47:01'],
                ['id' => 3, 'name' => 'Tea', 'sku' => 'tea', 'slug' => 'tea', 'stock' => 0, 'category_id' => 1, 'created_at' => '2025-07-23 19:48:06', 'updated_at' => '2025-07-23 19:48:06'],
                ['id' => 4, 'name' => 'Raisin', 'sku' => 'raisin', 'slug' => 'raisin', 'stock' => 0, 'category_id' => 2, 'created_at' => '2025-07-23 19:48:58', 'updated_at' => '2025-07-23 19:48:58'],
                ['id' => 5, 'name' => 'Seed', 'sku' => 'seed', 'slug' => 'seed', 'stock' => 0, 'category_id' => 4, 'created_at' => '2025-07-23 19:49:34', 'updated_at' => '2025-07-23 19:49:34'],
                ['id' => 6, 'name' => 'Cinnamon', 'sku' => 'cinnamon', 'slug' => 'cinnamon', 'stock' => 0, 'category_id' => 4, 'created_at' => '2025-07-23 19:53:44', 'updated_at' => '2025-07-23 19:53:44'],
                ['id' => 9, 'name' => 'Walnut', 'sku' => 'walnut', 'slug' => 'walnut', 'stock' => 0, 'category_id' => 3, 'created_at' => '2025-08-06 19:53:44', 'updated_at' => '2025-08-06 19:53:44'],
                ['id' => 10, 'name' => 'Peanut', 'sku' => 'peanut', 'slug' => 'peanut', 'stock' => 0, 'category_id' => 3, 'created_at' => '2025-08-06 20:53:54', 'updated_at' => '2025-08-06 20:53:54'],
                ['id' => 11, 'name' => 'Pistachio', 'sku' => 'pistachio', 'slug' => 'pistachio', 'stock' => 0, 'category_id' => 3, 'created_at' => '2025-08-06 20:53:54', 'updated_at' => '2025-08-06 20:53:54'],
                ['id' => 12, 'name' => 'Pecan', 'sku' => 'pecan', 'slug' => 'pecan', 'stock' => 0, 'category_id' => 3, 'created_at' => '2025-08-06 20:53:54', 'updated_at' => '2025-08-06 20:53:54'],
            ]);
        }

        // ========== Product Images ==========
        if (DB::table('product_images')->count() === 0) {
            DB::table('product_images')->insert([
                ['id' => 1, 'product_id' => 1, 'image_path' => 'almonds.jpg', 'is_main' => 1, 'created_at' => '2025-08-07 15:41:50', 'updated_at' => '2025-08-07 15:41:50'],
                ['id' => 2, 'product_id' => 2, 'image_path' => 'cashews.jpg', 'is_main' => 1, 'created_at' => '2025-08-07 15:41:50', 'updated_at' => '2025-08-07 15:41:50'],
                ['id' => 3, 'product_id' => 6, 'image_path' => 'cinnamon.jpg', 'is_main' => 1, 'created_at' => '2025-08-07 15:41:50', 'updated_at' => '2025-08-07 15:41:50'],
                ['id' => 4, 'product_id' => 10, 'image_path' => 'peanut.jpg', 'is_main' => 1, 'created_at' => '2025-08-07 15:41:50', 'updated_at' => '2025-08-07 15:41:50'],
                ['id' => 5, 'product_id' => 12, 'image_path' => 'pecan.jpg', 'is_main' => 1, 'created_at' => '2025-08-07 15:41:50', 'updated_at' => '2025-08-07 15:41:50'],
                ['id' => 6, 'product_id' => 11, 'image_path' => 'pistachio.jpg', 'is_main' => 1, 'created_at' => '2025-08-07 15:41:50', 'updated_at' => '2025-08-07 15:41:50'],
                ['id' => 7, 'product_id' => 4, 'image_path' => 'raisin.jpg', 'is_main' => 1, 'created_at' => '2025-08-07 15:41:50', 'updated_at' => '2025-08-07 15:41:50'],
                ['id' => 8, 'product_id' => 5, 'image_path' => 'seed.jpg', 'is_main' => 1, 'created_at' => '2025-08-07 15:41:50', 'updated_at' => '2025-08-07 15:41:50'],
                ['id' => 9, 'product_id' => 3, 'image_path' => 'tea.jpg', 'is_main' => 1, 'created_at' => '2025-08-07 15:41:50', 'updated_at' => '2025-08-07 15:41:50'],
                ['id' => 10, 'product_id' => 9, 'image_path' => 'walnut.jpg', 'is_main' => 1, 'created_at' => '2025-08-07 15:41:50', 'updated_at' => '2025-08-07 15:41:50'],
                ['id' => 16, 'product_id' => 11, 'image_path' => 'pistachio_1.jpg', 'is_main' => 0, 'created_at' => '2025-08-07 15:41:50', 'updated_at' => '2025-08-07 15:41:50'],
            ]);
        }

        // ========== Product Sizes ==========
        if (DB::table('product_sizes')->count() === 0) {
            DB::table('product_sizes')->insert([
                ['id' => 1, 'product_id' => 11, 'size' => '16oz', 'quantity' => 50, 'price' => '9.50', 'created_at' => '2025-08-07 21:15:19'],
                ['id' => 2, 'product_id' => 11, 'size' => '1lb', 'quantity' => 20, 'price' => '10.50', 'created_at' => '2025-08-07 21:15:19'],
                ['id' => 3, 'product_id' => 11, 'size' => '2lb', 'quantity' => 10, 'price' => '12.50', 'created_at' => '2025-08-07 21:15:19'],
                ['id' => 4, 'product_id' => 1, 'size' => '16oz', 'quantity' => 50, 'price' => '6.99', 'created_at' => '2025-08-07 21:16:07'],
                ['id' => 5, 'product_id' => 1, 'size' => '1lb', 'quantity' => 20, 'price' => '8.99', 'created_at' => '2025-08-07 21:16:07'],
                ['id' => 6, 'product_id' => 1, 'size' => '2lb', 'quantity' => 10, 'price' => '10.99', 'created_at' => '2025-08-07 21:16:07'],
                ['id' => 7, 'product_id' => 2, 'size' => '16oz', 'quantity' => 50, 'price' => '10.99', 'created_at' => '2025-08-07 21:16:07'],
                ['id' => 8, 'product_id' => 2, 'size' => '1lb', 'quantity' => 20, 'price' => '10.99', 'created_at' => '2025-08-07 21:16:07'],
                ['id' => 9, 'product_id' => 2, 'size' => '2lb', 'quantity' => 10, 'price' => '10.99', 'created_at' => '2025-08-07 21:16:07'],
                ['id' => 10, 'product_id' => 3, 'size' => '16oz', 'quantity' => 50, 'price' => '6.50', 'created_at' => '2025-08-07 21:16:07'],
                ['id' => 11, 'product_id' => 3, 'size' => '1lb', 'quantity' => 20, 'price' => '7.50', 'created_at' => '2025-08-07 21:16:07'],
                ['id' => 12, 'product_id' => 3, 'size' => '2lb', 'quantity' => 10, 'price' => '10.50', 'created_at' => '2025-08-07 21:16:07'],
                ['id' => 13, 'product_id' => 4, 'size' => '16oz', 'quantity' => 50, 'price' => '8.50', 'created_at' => '2025-08-07 21:16:07'],
                ['id' => 14, 'product_id' => 4, 'size' => '1lb', 'quantity' => 20, 'price' => '16.50', 'created_at' => '2025-08-07 21:16:07'],
                ['id' => 15, 'product_id' => 4, 'size' => '2lb', 'quantity' => 10, 'price' => '24.50', 'created_at' => '2025-08-07 21:16:07'],
                ['id' => 16, 'product_id' => 5, 'size' => '16oz', 'quantity' => 50, 'price' => '3.30', 'created_at' => '2025-08-07 21:17:07'],
                ['id' => 17, 'product_id' => 5, 'size' => '1lb', 'quantity' => 20, 'price' => '6.30', 'created_at' => '2025-08-07 21:17:07'],
                ['id' => 18, 'product_id' => 5, 'size' => '2lb', 'quantity' => 10, 'price' => '11.30', 'created_at' => '2025-08-07 21:17:07'],
                ['id' => 19, 'product_id' => 6, 'size' => '16oz', 'quantity' => 50, 'price' => '9.50', 'created_at' => '2025-08-07 21:17:07'],
                ['id' => 20, 'product_id' => 6, 'size' => '1lb', 'quantity' => 20, 'price' => '9.50', 'created_at' => '2025-08-07 21:17:07'],
                ['id' => 21, 'product_id' => 6, 'size' => '2lb', 'quantity' => 10, 'price' => '9.50', 'created_at' => '2025-08-07 21:17:07'],
                ['id' => 31, 'product_id' => 9, 'size' => '16oz', 'quantity' => 50, 'price' => '9.50', 'created_at' => '2025-08-07 21:17:53'],
                ['id' => 32, 'product_id' => 9, 'size' => '1lb', 'quantity' => 20, 'price' => '9.50', 'created_at' => '2025-08-07 21:17:53'],
                ['id' => 33, 'product_id' => 9, 'size' => '2lb', 'quantity' => 10, 'price' => '9.50', 'created_at' => '2025-08-07 21:17:53'],
                ['id' => 34, 'product_id' => 10, 'size' => '16oz', 'quantity' => 50, 'price' => '10.50', 'created_at' => '2025-08-07 21:17:53'],
                ['id' => 35, 'product_id' => 10, 'size' => '1lb', 'quantity' => 20, 'price' => '10.50', 'created_at' => '2025-08-07 21:17:53'],
                ['id' => 36, 'product_id' => 10, 'size' => '2lb', 'quantity' => 10, 'price' => '10.50', 'created_at' => '2025-08-07 21:17:53'],
                ['id' => 37, 'product_id' => 12, 'size' => '16oz', 'quantity' => 50, 'price' => '10.90', 'created_at' => '2025-08-07 21:18:11'],
                ['id' => 38, 'product_id' => 12, 'size' => '1lb', 'quantity' => 20, 'price' => '10.90', 'created_at' => '2025-08-07 21:18:11'],
                ['id' => 39, 'product_id' => 12, 'size' => '2lb', 'quantity' => 10, 'price' => '10.90', 'created_at' => '2025-08-07 21:18:11'],
            ]);
        }
    
    }
    public function down(): void
    {
        DB::table('product_sizes')->truncate();
        DB::table('product_images')->truncate();
        DB::table('products')->truncate();
        DB::table('categories')->truncate();
    }
};
