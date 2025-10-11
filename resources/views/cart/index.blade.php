@extends('layouts.frontend')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold mb-4">Cart</h2>

    <div class="row g-4">
        <!-- Left: Cart Items -->
        <div class="col-lg-8">
            <div class="table-responsive border p-3 bg-white shadow-sm">
                <table class="table align-middle">
                    <thead class="border-bottom">
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col" class="text-center">Quantity</th>
                            <th scope="col">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cartItems as $item)
                        <?php //dd($item); ?>
                            <tr>
                                <!-- Product -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img 
                                         src="{{ asset('images/products/' . $item->product->mainImage->image_path) }}"
                                             alt="{{ $item->product->name }}" 
                                             width="60" class="rounded me-3">
                                        <div>
                                            <strong>{{ $item->product->name }}</strong><br>
                                            <small class="text-muted">{{ $item->product->sku ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>

                                <!-- Price -->
                                <td>${{ number_format($item->unit_price, 2) }}</td>

                                <!-- Quantity -->
                                <td class="text-center">
                                    {{ $item->qty }}
                                    <!-- <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" 
                                               name="qty" 
                                               value="{{ $item->qty }}" 
                                               min="1" 
                                               class="form-control text-center" 
                                               style="width:80px; display:inline-block;">
                                        <button type="submit" class="btn btn-sm btn-outline-dark ms-2">Update</button>
                                    </form> -->
                                </td>

                                <!-- Subtotal -->
                                <td>${{ number_format($item->unit_price * $item->qty, 2) }}</td>

                                <!-- Remove -->
                                <td>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">&times;</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Your cart is empty</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Coupon -->
            <div class="mt-3 d-flex gap-2">
                <input type="text" name="coupon" placeholder="Coupon code" class="form-control" style="max-width: 250px;">
                <button class="btn btn-warning fw-bold bg-yellow-500 text-white hover:bg-yellow-600">Apply Coupon</button>
            </div>
        </div>

        <!-- Right: Cart Totals -->
        <div class="col-lg-4">
            <div class="border p-4 bg-white shadow-sm">
                <h5 class="fw-bold border-bottom pb-2">Cart Totals</h5>

                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Subtotal</span>
                    <strong>${{ number_format($subtotal, 2) }}</strong>
                </div>

                <!-- <div class="py-3">
                    <p class="mb-1">Shipping</p>
                    <small class="text-muted">Enter your address to view shipping options.</small><br>
                    <a href="#" class="text-decoration-underline small">Calculate shipping</a>
                </div> -->

                <div class="d-flex justify-content-between py-2 border-top border-bottom">
                    <span>Total</span>
                    <strong>${{ number_format($subtotal, 2) }}</strong>
                </div>

                <a href="{{ route('cart.checkout') }}" class="bg-yellow-500 text-white btn btn-warning w-100 mt-3 fw-bold hover:bg-yellow-600">
                    Proceed To Checkout
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
