<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\WishlistResolver;

class ProductController extends Controller
{
   public function show($slug)
{
    $product = Product::with([
        'category',
        'images' => fn ($q) => $q->orderByDesc('is_main')->orderBy('id'),
        'sizes'  => fn ($q) => $q->orderBy('price'),
    ])->where('slug', $slug)->firstOrFail();

    $defaultSize = $product->sizes->first();
    $mainImage   = $product->images->where('is_main', 1)->first() ?? $product->images->first();

    $inWishlist = false;
    $wishlistItemId = null;

    $wl = WishlistResolver::current();
    if ($wl->exists) {
        $wishlistItem = $wl->items()
            ->where('product_id', $product->id)
            ->when($defaultSize, fn($q) => $q->where('product_size_id', $defaultSize->id))
            ->first();

        if ($wishlistItem) {
            $inWishlist = true;
            $wishlistItemId = $wishlistItem->id;
        }
    }

    $relatedProducts = Product::where('category_id', $product->category_id)
                        ->where('id', '!=', $product->id)
                        ->limit(5)
                        ->get();

    return view('frontend.product', compact(
        'product',
        'relatedProducts',
        'defaultSize',
        'mainImage',
        'inWishlist',
        'wishlistItemId'   // 👈 now available in blade
    ));
}

}
