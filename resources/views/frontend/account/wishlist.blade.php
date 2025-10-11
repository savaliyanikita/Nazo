@extends('layouts.frontend')

@section('content')
<!-- Wishlist Banner -->
<div class="relative h-64 bg-cover bg-center" style="background-image: url('{{ asset('images/slider1.jpg') }}')">
  <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
    <h1 class="text-white text-4xl font-extrabold">Wishlist</h1>
  </div>
</div>
<!-- Breadcrumb -->
<div class="bg-white py-3 border-b text-sm">
  <div class="container mx-auto px-4 text-gray-500">
    <a href="{{ route('home') }}" class="hover:underline">Home</a> /
    <span class="text-gray-800 font-medium">Wishlist</span>
  </div>
</div>

<div class="container py-5">
    <div class="row">
    <!-- Sidebar -->
        <div class="col-md-3">
            @include('frontend.components.accountSidebar')
        </div>
    <!-- Main Content -->
        <div class="col-md-9">
    <h2 class="mb-4">Your Wishlist</h2>

    @if($wishlist && $wishlist->items->count())
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Size</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wishlist->items as $item)
                        <tr id="wishlist-item-{{ $item->id }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('images/products/' . ($item->product->mainImage->image_path ?? 'default.jpg')) }}"
                                         alt="{{ $item->product->name }}" width="60" class="rounded me-3">
                                    <span>{{ $item->product->name }}</span>
                                </div>
                            </td>
                            <td>{{ $item->product->sku ?? '—' }}</td>
                            <td>{{ $item->size->size ?? '-' }}</td>
                            <td>
                                <button class="btn btn-sm btn-danger remove-wishlist" data-id="{{ $item->id }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="wishlistAlert" style="display:none"></div>
        </div>
    @else
        <p class="text-muted">Your wishlist is empty.</p>
    @endif
</div>

    </div>
</div>
@endsection
<script>
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("remove-wishlist")) {
        const itemId = e.target.dataset.id;

        fetch(`/wishlist/remove/${itemId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // remove item row
                document.querySelector(`#wishlist-item-${itemId}`).remove();

                // optional: show alert
                const alertBox = document.getElementById("wishlistAlert");
                alertBox.textContent = data.message;
                alertBox.className = "alert alert-success mt-2";
                alertBox.style.display = "block";

                setTimeout(() => alertBox.style.display = "none", 3000);
            }
        })
        .catch(err => console.error("Wishlist error:", err));
    }
});

</script>