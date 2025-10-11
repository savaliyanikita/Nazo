<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $allCategories = Category::all();
        $category = Category::where('slug', $slug)->firstOrFail();
         $sort = request('sort');
         $products = Product::with('mainImage')
                ->withMinPrice()  
                ->where('category_id', $category->id);
        // $products = $category->products()->latest()->paginate(12);

        // Sorting logic
        switch ($sort) {
            case 'price_asc':
                $products->orderBy('sizes_min_price', 'asc');
                break;
            case 'price_desc':
                $products->orderBy('sizes_min_price', 'desc');
                break;
            case 'name_asc':
                $products->orderBy('name', 'asc');  
                break;
            case 'name_desc':
                $products->orderBy('name', 'desc');
                break;
            default:
                $products->latest();
        }
        $products = $products->paginate(12)->withQueryString(); // preserve sort in pagination
        
        return view('frontend.category', compact('allCategories','category', 'products'));
    }
}

