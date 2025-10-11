@extends('layouts.frontend')

@section('content')
<div class="container my-5">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Checkout</li>
        </ol>
    </nav>

    <h2 class="fw-bold mb-4">Checkout</h2>

    <div class="row g-4">
        <!-- LEFT: Cart + Shipping -->
        <div class="col-lg-8">
            <!-- Delivery or Pickup -->
            <div class="border p-3 bg-white shadow-sm mb-4">
                <h5 class="fw-bold mb-3">How would you like your Order?</h5>
                <div class="row">
                    <div class="col-md-6">
                        <label class="border rounded p-3 d-block">
                            <input type="radio" name="delivery_type" value="delivery" checked>
                            <strong>Delivery</strong>
                            <p class="text-muted small mb-0">Free shipping on most orders over $500</p>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="border rounded p-3 d-block">
                            <input type="radio" name="delivery_type" value="pickup">
                            <strong>Pickup</strong>
                            <p class="text-muted small mb-0">Ready in as little as 4 hours</p>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Your Cart -->
            <div class="border p-3 bg-white shadow-sm mb-4">
                <h5 class="fw-bold mb-3">Your Cart</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cartItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('images/products/' . ($item->product->mainImage->image_path ?? 'default.jpg')) }}"
                                                 alt="{{ $item->product->name }}" width="60" class="rounded me-3">
                                            <div>
                                                <strong>{{ $item->product->name }}</strong><br>
                                                <small class="text-muted">{{ $item->product->sku ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $item->qty }}</td>
                                    <td class="text-end">${{ number_format($item->unit_price * $item->qty, 2) }}</td>
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
                                    <td colspan="4" class="text-center text-muted">Your cart is empty</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Coupon -->
                <div class="mt-3 d-flex gap-2">
                    <input type="text" name="coupon" placeholder="Coupon code" class="form-control" style="max-width:250px;">
                    <button class="btn btn-warning fw-bold">Apply Coupon</button>
                </div>
            </div>

            <!-- Shipping / Billing Info -->
            <div class="border p-3 bg-white shadow-sm">
                <h5 class="fw-bold mb-3">Shipping / Billing Details</h5>

                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                        <small class="text-muted">We'll send order updates to this email.</small>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>First Name *</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Last Name *</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Phone *</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Postal Code *</label>
                            <input type="text" name="postal_code" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label>Address *</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>City *</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>State *</label>
                            <input type="text" name="state" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark mt-4 w-100 fw-bold">Place Order</button>
                </form>
            </div>
        </div>

        <!-- RIGHT: Order Summary -->
        <div class="col-lg-4">
            <div class="border p-4 bg-white shadow-sm">
                <h5 class="fw-bold border-bottom pb-2">Order Summary</h5>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Subtotal</span>
                    <strong>${{ number_format($subtotal, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Discount</span>
                    <strong> - $0.00 </strong>
                </div>
                <div class="d-flex justify-content-between py-2 border-top border-bottom">
                    <span>Total</span>
                    <strong>${{ number_format($subtotal, 2) }}</strong>
                </div>
                <button class="btn btn-warning w-100 mt-3 fw-bold">Proceed To Payment</button>
            </div>
        </div>
    </div>
</div>
@endsection
