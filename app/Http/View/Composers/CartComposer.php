<?php
// app/Http/View/Composers/CartComposer.php
namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\CartItem;

class CartComposer
{
    public function compose(View $view)
    {
        $cartId = session('cart_id'); // Or auth()->id() if tied to user
        $cartItems = CartItem::with('product', 'productSize')
            ->when($cartId, fn($q) => $q->where('cart_id', $cartId))
            ->get();

        $view->with('cartItems', $cartItems);
        $view->with('cartCount', $cartItems->sum('qty'));
        $view->with('cartTotal', $cartItems->sum(fn($i) => $i->qty * $i->unit_price));
    }
}
