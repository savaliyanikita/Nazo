@extends('layouts.frontend')

@section('content')
<!-- Checkout Banner -->
<div class="relative h-64 bg-cover bg-center" style="background-image: url('{{ asset('images/slider1.jpg') }}')">
  <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
    <h1 class="text-white text-4xl font-extrabold">Checkout</h1>
  </div>
</div>

<!-- Breadcrumb -->
<div class="bg-white py-3 border-b text-sm">
  <div class="container mx-auto px-4 text-gray-500">
    <a href="{{ route('home') }}" class="hover:underline">Home</a> /
    <span class="text-gray-800 font-medium">Checkout</span>
  </div>
</div>

<div class="container my-5">
    <div class="row g-4">

        <!-- Wrap everything inside one form -->
        <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST" class="row g-4">
            @csrf

            <!-- Hidden delivery type -->
            <input type="hidden" name="delivery_type" id="deliveryTypeField" value="delivery">

            <!-- Delivery or Pickup -->
            <div class="border p-3 bg-white shadow-sm mb-4">
                <h5 class="fw-bold mb-3">How would you like your Order?</h5>
                <div class="row">
                    <div class="col-md-6">
                        <label class="border rounded p-3 d-block">
                            <input type="radio" name="delivery_type_option" value="delivery" checked>
                            <strong>Delivery</strong>
                            <p class="text-muted small mb-0">Free shipping on most orders over $500</p>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="border rounded p-3 d-block">
                            <input type="radio" name="delivery_type_option" value="pickup">
                            <strong>Pickup</strong>
                            <p class="text-muted small mb-0">Ready in as little as 4 hours</p>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Cart Items -->
            <div class="border p-3 bg-white shadow-sm mb-4">
                <h5 class="fw-bold mb-3">Your Cart</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Size</th>
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
                                    <td class="text-center">{{ $item->size->size }}</td>
                                    <td class="text-end">${{ number_format($item->unit_price * $item->qty, 2) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-item"
                                                data-id="{{ $item->id }}">&times;</button>
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
            </div>

            <!-- LEFT: Coupon -->
            <div class="col-lg-8">            
                <div class="mt-3 d-flex gap-2">
                    <input type="text" name="coupon" placeholder="Coupon code" class="form-control" style="max-width:250px;">
                    <button type="button" class="btn btn-warning fw-bold bg-yellow-500 text-white hover:bg-yellow-600">Apply Coupon</button>
                    <a href="{{ route('home') }}" class="btn btn-warning fw-bold bg-yellow-500 text-white hover:bg-yellow-600">Continue Shopping</a>
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
                        <strong>- $0.00</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-top border-bottom">
                        <span>Total</span>
                        <strong>${{ number_format($subtotal, 2) }}</strong>
                    </div>

                    <!-- Dynamic button -->
                    <button id="proceedBtn" type="button"
                            class="btn btn-warning w-100 mt-3 fw-bold bg-yellow-500 text-white hover:bg-yellow-600">
                        Proceed to Checkout
                    </button>
                </div>
            </div>

            <!-- Hidden Shipping Section -->
            <div id="shippingSection" class="border p-3 bg-white shadow-sm mt-4" style="display: none;">
                <h5 class="fw-bold mb-3">Shipping / Billing Details</h5>

                <div class="mb-3">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label>First Name *</label>
                        <input type="text" name="first_name" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Last Name *</label>
                        <input type="text" name="last_name" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Phone *</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Postal Code *</label>
                        <input type="text" name="postal_code" class="form-control">
                    </div>
                    <div class="col-12">
                        <label>Address *</label>
                        <input type="text" name="address" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>City *</label>
                        <input type="text" name="city" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>State *</label>
                        <input type="text" name="state" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn mt-4 w-100 fw-bold bg-yellow-500 text-white hover:bg-yellow-600">
                    Place Order
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const proceedBtn = document.getElementById("proceedBtn");
    const shippingSection = document.getElementById("shippingSection");
    const deliveryOptions = document.querySelectorAll('input[name="delivery_type_option"]');
    const checkoutForm = document.getElementById("checkoutForm");
    const deliveryTypeField = document.getElementById("deliveryTypeField");

    function updateUI() {
        const deliveryType = document.querySelector('input[name="delivery_type_option"]:checked').value;
        deliveryTypeField.value = deliveryType;

        if (deliveryType === "pickup") {
            shippingSection.style.display = "none";
            proceedBtn.textContent = "Place Order";
        } else {
            // delivery → first show "Proceed to Checkout"
            proceedBtn.textContent = "Proceed to Checkout";
        }
    }

    deliveryOptions.forEach(option => {
        option.addEventListener("change", updateUI);
    });

    proceedBtn.addEventListener("click", function (e) {
        e.preventDefault();
        const deliveryType = deliveryTypeField.value;

        if (deliveryType === "delivery") {
            if (shippingSection.style.display === "none") {
                shippingSection.style.display = "block";
                shippingSection.scrollIntoView({ behavior: "smooth" });
            } else {
                checkoutForm.submit();
            }
        } else {
            // pickup
            checkoutForm.submit();
        }
    });

    updateUI();
});

document.querySelectorAll('.remove-item').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        fetch(`/cart/remove/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload(); // refresh cart
            }
        });
    });
});
</script>
@endpush
