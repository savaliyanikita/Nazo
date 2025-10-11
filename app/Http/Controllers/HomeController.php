<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache categories for 1 hour to avoid repeat queries
        $categories = Cache::remember('categories_all', 3600, function () {
            return \App\Models\Category::all();
        });

        // Eager-load product relations to avoid N+1 queries
        $newArrivals = Product::with(['mainImage', 'sizes'])
            ->withMinPrice()
            ->latest()
            ->take(5)
            ->get();

        $googleReviews = [
            ['text' => 'Amazing service and fresh products!', 'author' => 'John D.'],
            ['text' => 'Best dried fruits supplier we’ve worked with.', 'author' => 'Sana M.'],
            ['text' => 'Top-notch quality and on-time delivery!', 'author' => 'Ali R.'],
            ['text' => 'Highly recommend for wholesale needs.', 'author' => 'Nina K.'],
            ['text' => 'The raisins and figs are just superb!', 'author' => 'Michael G.'],
            ['text' => 'Very happy with the consistency and taste.', 'author' => 'Zara A.'],
            ['text' => 'Very happy with the consistency and taste.', 'author' => 'Bella M.'],
            ['text' => 'Very happy with the consistency and taste.', 'author' => 'Rachel G.'],
            ['text' => 'Very happy with the consistency and taste.', 'author' => 'Amanda M.'],
            ['text' => 'Very happy with the consistency and taste.', 'author' => 'Martin R.'],
        ];

        return view('frontend.home', compact('categories', 'newArrivals', 'googleReviews'));
    }
}
