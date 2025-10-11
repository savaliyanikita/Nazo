<?php

namespace App\Support;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartResolver
{
    /**
     * Get or create the current cart (user or guest)
     */
    public static function current(): Cart
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(
                ['user_id' => Auth::id(), 'status' => 'open'],
                ['ip_address' => request()->ip(), 'token' => Str::uuid()]
            );

            // Merge guest cart if cookie exists
            if (request()->hasCookie('cart_token')) {
                $guestToken = request()->cookie('cart_token');
                $guestCart  = Cart::where('token', $guestToken)
                                ->whereNull('user_id')
                                ->first();

                if ($guestCart) {
                    self::mergeCarts($guestCart, $cart);
                    $guestCart->delete();
                    cookie()->queue(cookie()->forget('cart_token'));
                }
            }

            return $cart;
        }

        // Guest
        $token = request()->cookie('cart_token') ?? Str::uuid()->toString();
        $cart  = Cart::firstOrCreate(
            ['token' => $token, 'status' => 'open', 'user_id' => null],
            ['ip_address' => request()->ip()]
        );

        cookie()->queue(cookie('cart_token', $token, 60 * 24 * 7)); // 7 days
        return $cart;
    }

    /**
     * Merge guest cart into user cart
     */
    public static function mergeCarts(Cart $guestCart, Cart $userCart): void
    {
        foreach ($guestCart->items as $gi) {
            $existing = $userCart->items()
                ->where('product_id', $gi->product_id)
                ->where('product_size_id', $gi->product_size_id)
                ->first();

            if ($existing) {
                $existing->qty += $gi->qty;
                $existing->save();
                $gi->delete();
            } else {
                $gi->cart_id = $userCart->id;
                $gi->save();
            }
        }

        self::recalcTotals($userCart);
    }

    /**
     * Recalculate totals
     */
    public static function recalcTotals(Cart $cart): void
    {
        $cart->load('items');
        $subtotal = $cart->items->sum(fn($i) => $i->qty * $i->unit_price);
        $discount = $cart->discount ?? 0;

        $cart->sub_total = $subtotal;
        $cart->total     = max($subtotal - $discount, 0);
        $cart->save();
    }

    /**
     * After login/register: attach guest cart to user
     */
    public static function attachGuestToUser(int $userId): void
    {
        $token = request()->cookie('cart_token');
        if (!$token) return;

        $guest = Cart::where('token', $token)->whereNull('user_id')->first();
        if (!$guest) return;

        $userCart = Cart::firstOrCreate(
            ['user_id' => $userId, 'status' => 'open'],
            ['ip_address' => request()->ip(), 'token' => Str::uuid()]
        );

        self::mergeCarts($guest, $userCart);
        $guest->delete();
        cookie()->queue(cookie()->forget('cart_token'));
    }
}
