<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Support\CartResolver;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $cartItems = $user->cartItems()->with('product')->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty.'
                ]);
            }

            $order = Order::create([
                'user_id'      => $user->id,
                'delivery_type'=> $request->delivery_type,
                'status'       => 'pending',
                'email'        => $request->email,
                'first_name'   => $request->first_name,
                'last_name'    => $request->last_name,
                'phone'        => $request->phone,
                'address'      => $request->address,
                'city'         => $request->city,
                'state'        => $request->state,
                'postal_code'  => $request->postal_code,
                'subtotal'     => $cartItems->sum(fn($i) => $i->unit_price * $i->qty),
                'discount'     => 0,
                'total'        => $cartItems->sum(fn($i) => $i->unit_price * $i->qty),
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id'     => $item->product_id,
                    'product_size_id'=> $item->size_id,
                    'qty'            => $item->qty,
                    'unit_price'     => $item->unit_price,
                ]);
            }

            // close cart instead of deleting
            $user->cartItems()->update(['status' => 'closed']);
            return redirect()->route('thankyou')->with('success', 'Order placed successfully!');
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Order placed successfully!',
            //     'order_id'=> $order->id
            // ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: '.$e->getMessage()
            ], 500);
        }
    }

}

