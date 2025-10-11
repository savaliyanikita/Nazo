<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
use App\Support\CartResolver;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share categories + cart count with all views
        View::composer('*', function ($view) {
            // Cache categories to avoid hitting DB every time
           $categories = Cache::remember('categories_all', 60 * 24 * 7, function () {
                return Category::all();
            });
            $cartCount = 0;
            // Cart count optimized: session for guests, db for logged-in
            // if (Auth::check()) {
            //     $cart = CartResolver::current()->loadMissing('items');
            //     $cartCount = $cart->items->sum('qty');
            // } else {
            //     $cartCount = session('cart_count', 0);
            // }

            $cartCount = 0;
            if (auth()->check()) {
                $cartCount = auth()->user()->cartItemCount(true);
            } else {
                $cartCount = session('cart_count', 0);
            }

            $view->with([
                'categories' => $categories,
                'cartCount'  => $cartCount,
            ]);
        });
    }
}
