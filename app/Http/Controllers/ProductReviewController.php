<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Check if user purchased this product (pseudo check)
        $user = Auth::user();
        $hasBought = $user && $user->orders()
            ->whereHas('items', fn($q) => $q->where('product_id', $request->product_id))
            ->exists();

        if (!$hasBought) {
            return response()->json(['not_allowed' => true]);
        }

        ProductReview::create([
            'user_id' => $user?->id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'name' => $request->name,
            'message' => $request->message,
        ]);

        return response()->json(['success' => true]);
    }
}
