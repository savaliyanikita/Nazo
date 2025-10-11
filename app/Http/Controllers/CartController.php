<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSize;
use App\Support\CartResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = CartResolver::current()->load(['items.product.mainImage', 'items.size']);
        $cartItems = $cart->items ?? collect();
        $subtotal = $cartItems->sum(fn($item) => $item->unit_price * $item->qty);

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'size_id'    => ['required','integer','exists:product_sizes,id'],
            'qty'        => ['required','integer','min:1'],
        ]);

        $product = Product::findOrFail($data['product_id']);
        $size    = ProductSize::where('product_id', $product->id)
                              ->where('id', $data['size_id'])->firstOrFail();

        $cart = CartResolver::current();
        $qty  = min($data['qty'], $size->quantity);

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->where('product_size_id', $size->id)
            ->first();

        if ($item) {
            $item->qty = min($item->qty + $qty, $size->quantity);
            $item->save();
        } else {
            $cart->items()->create([
                'product_id'      => $product->id,
                'product_size_id' => $size->id,
                'qty'             => $qty,
                'unit_price'      => $size->price,
            ]);
        }

        CartResolver::recalcTotals($cart);
        $cartCount = $cart->items()->sum('qty');
        if (!Auth::check()) {
            session(['cart_count' => $cartCount]);
        }
        
        return response()->json([
            'success' => true,
            'count'   => $cart->items()->sum('qty'),
            'guest'   => !auth()->check(),
            'name'    => $product->name
        ]);
    }

    public function checkout()
    {
        abort_unless(Auth::check(), 403); // guests cannot checkout

        $cart = CartResolver::current()->load(['items.product.mainImage', 'items.size']);
        $cartItems = $cart->items ?? collect();
        $subtotal  = $cartItems->sum(fn($item) => $item->unit_price * $item->qty);

        return view('frontend.checkout', compact('cart', 'cartItems', 'subtotal'));
    }

    public function offcanvas()
    {
        $cart = CartResolver::current()->load(['items.product.mainImage', 'items.size']);
        $cartItems = $cart->items ?? collect();
        $cartTotal = $cartItems->sum(fn($i) => $i->qty * $i->unit_price);

        return view('partials.offcanvas_cart', compact('cartItems', 'cartTotal'));
    }

    public function remove($id)
    {
        $cart = CartResolver::current()->load('items');
        $item = $cart->items->firstWhere('id', $id);

        if (!$item) {
            abort(404, 'Item not found in your cart');
        }

        $item->delete();
        CartResolver::recalcTotals($cart);
        $cartCount = $cart->items()->sum('qty');
        if (!Auth::check()) {
            session(['cart_count' => $cartCount]);
        }

        return redirect()->back()->with('success', 'Item removed from cart');
    }
}
