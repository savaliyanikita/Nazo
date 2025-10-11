<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Support\WishlistResolver;

class AccountController extends Controller
{
    public function index()
    {
        return view('frontend.account.index');
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('frontend.account.orders', compact('orders'));
    }

    public function wishlist()
    {
        $wishlist = WishlistResolver::current()->load('items.product', 'items.size');
        return view('frontend.account.wishlist', compact('wishlist'));
    }

    public function subscriptions()
    {
        return view('frontend.account.subscriptions');
    }

    public function wallet()
    {
        return view('frontend.account.wallet');
    }

    public function addressBook()
    {
        return view('frontend.account.address-book');
    }

    public function emailPreferences()
    {
        return view('frontend.account.email-preferences');
    }
}
