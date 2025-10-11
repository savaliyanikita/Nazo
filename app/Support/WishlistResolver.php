<?php
namespace App\Support;

use App\Models\Wishlist;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class WishlistResolver
{
    public static function current(): Wishlist
    {
        if (Auth::check()) {
            return Wishlist::firstOrCreate(['user_id' => Auth::id()], ['ip_address' => request()->ip()]);
        }
        $token = request()->cookie('wish_token');
        if (!$token) {
            $token = Str::uuid()->toString();
            cookie()->queue(cookie('wish_token', $token, 60*24*90));
        }
        return Wishlist::firstOrCreate(['token' => $token], ['ip_address' => request()->ip()]);
    }

    public static function attachGuestToUser($userId): void
    {
        $token = request()->cookie('wish_token');
        if (!$token) return;
        $guest   = Wishlist::where('token', $token)->first();
        $userWL  = Wishlist::firstOrCreate(['user_id' => $userId], ['ip_address' => request()->ip()]);
        if (!$guest) return;

        foreach ($guest->items as $gi) {
            $exists = $userWL->items()
                ->where('product_id', $gi->product_id)
                ->where('product_size_id', $gi->product_size_id)
                ->exists();
            if (! $exists) {
                $gi->wishlist_id = $userWL->id;
                $gi->save();
            } else {
                $gi->delete();
            }
        }
        $guest->delete();
    }
}
