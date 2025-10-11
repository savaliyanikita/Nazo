<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;           
use Illuminate\Support\Str;       

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Teas', 'Raisins', 'Nuts', 'Seeds & Peas', 'Tropical Fruits', 'Plums & Berries',
            'Figs', 'Halal Gummies / Candies', 'Fresh Dates', 'Pickles / Canned Foods',
            'Oils', 'Spices', 'Dried Vegetables', 'Daals & Lentils', 'Rice'
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat)
            ]);
        }
    }
}
