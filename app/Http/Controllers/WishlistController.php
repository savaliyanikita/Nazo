<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\WishlistResolver;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = WishlistResolver::current()->load('items.product','items.size');
        return view('frontend.account.wishlist', compact('wishlist'));
    }


    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','exists:products,id'],
            'size_id'    => ['nullable','exists:product_sizes,id'],
        ]);

        $wl = WishlistResolver::current();

        $item = $wl->items()
            ->where('product_id', $data['product_id'])
            ->when($data['size_id'] ?? null, fn($q,$sid)=>$q->where('product_size_id',$sid))
            ->first();

        if (! $item) {
            $item = $wl->items()->create([
                'product_id'      => $data['product_id'],
                'product_size_id' => $data['size_id'] ?? null,
            ]);
        }

        return response()->json([
            'success' => true,
            'id'      => $item->id,
            'message' => 'Item added to wishlist'
        ]);
    }



    // public function remove(Request $request, $itemId)
    // {
    //     $wl = WishlistResolver::current();
    //     $item = $wl->items()->where('id',$itemId)->first();

    //     if ($item) {
    //         $item->delete();
    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => true,
    //                 'removed' => true,
    //                 'message' => 'Item removed from wishlist'
    //             ]);
    //         }
    //         return back()->with('success', 'Item removed from wishlist');
    //     }

    //     if ($request->ajax()) {
    //         return response()->json(['success' => false, 'message' => 'Item not found'], 404);
    //     }

    //     return back()->with('error', 'Item not found');
    // }
    public function remove($itemId)
    {
        $removed = WishlistResolver::current()->items()->where('id',$itemId)->delete();

        return response()->json([
            'success' => (bool) $removed,
            'message' => 'Item removed from wishlist'
        ]);
    }
}
