<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Your Cart</h5>
    <span class="badge rounded-pill bg-warning text-dark">
        {{ $cartItems->sum('qty') }}
    </span>
</div>

@if($cartItems->isNotEmpty())
    <ul class="list-group mb-3">
        @foreach($cartItems as $item)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $item->product->name }}</strong>
                    <div class="text-muted small">
                        {{ $item->size->size ?? '' }} × {{ $item->qty }}
                    </div>
                </div>
                 @auth 
                <span class="fw-bold">${{ number_format($item->unit_price * $item->qty, 2) }}</span>
                @else

                @endauth
            </li>
        @endforeach
        <li class="list-group-item d-flex justify-content-between">
            <strong>Total</strong>
            @auth   
            <strong>${{ number_format($cartTotal, 2) }}</strong>
            @else
            <a href="#" onclick="showAuth('signin')">Please Login to see Price</a>
            @endauth
        </li>
    </ul>
     @if(auth()->check())
    <a href="{{ route('cart.checkout') }}" class="btn w-100 btn btn-warning fw-bold bg-yellow-500 text-white hover:bg-yellow-600">
        Continue to Checkout
    </a>
    @else
       <a href="#" onclick="showAuth('signin')" class="btn w-100 btn btn-warning fw-bold bg-yellow-500 text-white hover:bg-yellow-600">Checkout</a>
    @endif


@else
    <p class="text-center text-muted">Your cart is empty</p>
@endif
