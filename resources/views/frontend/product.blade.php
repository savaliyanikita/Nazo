@extends('layouts.frontend')

@section('content')
<!-- Category Banner -->
<div class="relative h-64 bg-cover bg-center" style="background-image: url('{{ asset('images/category-banners/' . $product->category->slug . '.jpg') }}')">
  <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
    <h1 class="text-white text-4xl font-extrabold">{{ $product->category->name }}</h1>
  </div>
</div>

<!-- Breadcrumb -->
<div class="bg-white py-3 border-b text-sm">
  <div class="container mx-auto px-4 text-gray-500">
    <a href="{{ route('home') }}" class="hover:underline">Home</a> /
    <a href="{{ route('category.show', $product->category->slug) }}" class="hover:underline">{{ $product->category->name }}</a> /
    <span class="text-gray-800 font-medium">{{ $product->name }}</span>
  </div>
</div>

<!-- Product Details -->
<section class="py-12">
  <div class="container mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-10">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

   {{-- LEFT: Product Images --}}
    <div class="space-y-3">
    {{-- MAIN image with fixed size --}}
    <div class="w-full max-w-xl mx-auto bg-white rounded shadow border">
        <img
        id="productMainImg"
        src="{{ asset('images/products/' . $mainImage->image_path) }}"
        alt="{{ $product->name }}"
        class="w-full h-[440px] object-contain"   {{-- fixed height, keeps ratio --}}
        />
    </div>

    {{-- Thumbnails --}}
    <div class="flex flex-wrap justify-center gap-3">
        @foreach($product->images as $img)
        <img
            src="{{ asset('images/products/' . $img->image_path) }}"
            data-large="{{ asset('images/products/' . $img->image_path) }}"
            class="thumb w-20 h-20 object-cover border rounded cursor-pointer {{ $img->is_main ? 'ring ring-yellow-400' : '' }}"
            alt="{{ $product->name }}"
        />
        @endforeach
    </div>
    </div>
    <!-- {{-- RIGHT: Product Info --}} -->
    <div>
      {{-- Name + Stars --}}
      <h1 class="text-2xl font-bold mb-1 fs-2">{{ $product->name }}</h1>
        <div class="text-yellow-500 flex items-center gap-1 mb-2">
          @for ($i = 0; $i < 5; $i++)
            <i class="fas fa-star"></i>
          @endfor
          <span class="text-gray-600 ml-2">(4.5)</span>
        </div>
        {{-- SIZE BUTTONS --}}
        <div class="mb-4">
          <p class="text-sm font-semibold text-gray-700 mb-2">Size: <span id="selectedSizeLabel" class="font-bold text-gray-900"></span></p>
          <div id="sizeButtons" class="flex flex-wrap gap-3">
            @foreach ($product->sizes as $size)
              <label class="cursor-pointer">
                <input
                  type="radio"
                  name="size_id"
                  class="peer sr-only sizeRadio"
                  value="{{ $size->id }}"
                  data-price="{{ $size->price }}"
                  data-stock="{{ $size->quantity }}"
                  @checked(optional($defaultSize)->id === $size->id)
                />
                <div class="rounded-lg border px-4 py-3 peer-checked:border-yellow-500 peer-checked:ring-2 peer-checked:ring-yellow-200">
                  <div class="font-semibold">{{ $size->size }}</div>
                  {{-- You can show price per button; hide for guests if needed --}}
                  @if(Auth::check())
                    <div class="text-sm text-gray-600">$ {{ number_format($size->price, 2) }}</div>          
                  @endif
                  
                </div>
              </label>
            @endforeach
          </div>
          <p id="stockHint" class="text-xs text-gray-500 mt-1"></p>
        </div>

        {{-- Price display (auto-changes with size) --}}
        @php $initialPrice = $defaultSize?->price ?? $product->min_price; @endphp
        <div class="mb-4">
          @if(Auth::check())
            <span class="text-3xl font-semibold text-green-700" id="priceValue">
              ${{ number_format($initialPrice, 2) }}
            </span>
          @else
            <span class="text-3xl font-semibold text-muted" >
              Login to see price
            </span>
          @endif  
        </div>

        {{-- Primary actions row: Add to Cart + Wishlist heart --}}
        <!-- <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST" class="mb-3"> -->
          <!-- @csrf -->
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <input type="hidden" id="selectedSizeId" name="size_id" value="{{ optional($defaultSize)->id }}">
          <input type="hidden" id="selectedQty" name="qty" value="1">
          {{-- Qty control BELOW the primary buttons --}}
          <div>
            <div class="inline-flex items-center gap-2 fs-5">
              <button type="button" id="qtyMinus"
                      class="border rounded w-9 h-9 flex items-center justify-center hover:bg-gray-50">-</button>
              <input
                type="text"
                id="qtyInput"
                class="border rounded w-14 h-9 text-center focus:outline-none"
                value="1"
                inputmode="numeric"
              >
              <button type="button" id="qtyPlus"
                      class="border rounded w-9 h-9 flex items-center justify-center hover:bg-gray-50">+</button>

            <button type="button"
              id="addToCartBtn"
              data-url="{{ route('cart.add') }}"
              data-product="{{ $product->id }}"
              data-size="{{ optional($defaultSize)->id }}"
              class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600 disabled:opacity-50 disabled:cursor-not-allowed ml-3">
              Add to Cart
            </button>


            {{-- Wishlist Heart --}}
            
            <!-- <form method="POST" action="{{ route('wishlist.add') }}" class="inline">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <input type="hidden" name="size_id" id="wishSizeId" value="{{ optional($defaultSize)->id }}">
              <button type="button" 
                      id="wishlistBtn" 
                      data-product="{{ $product->id }}" 
                      data-size="{{ optional($defaultSize)->id }}"
                      data-item-id="{{ $wishlistItemId ?? '' }}"
                      class="border px-4 py-2 rounded hover:bg-gray-50 ml-3">
                <i id="wishlistIcon" class="{{ $inWishlist ? 'fas text-yellow-500' : 'far text-gray-700' }} fa-heart"></i>
              </button>


              <div id="wishlistAlert" class="mt-2 text-sm hidden"></div>



              </form> -->
              @auth
                <button type="button"
                        id="wishlistBtn"
                        data-product="{{ $product->id }}"
                        data-size="{{ optional($defaultSize)->id }}"
                        data-item-id="{{ $wishlistItemId ?? '' }}"
                        class="border px-4 py-2 rounded hover:bg-gray-50 ml-3">
                  <i id="wishlistIcon"
                    class="{{ $inWishlist ? 'fas text-yellow-500' : 'far text-gray-700' }} fa-heart"></i>
                </button>
              @else
                <button type="button"
                        onclick="showAuth('signin')"
                        class="border px-4 py-2 rounded hover:bg-gray-50 ml-3">
                  <i class="far fa-heart text-gray-700"></i>
                </button>
              @endauth

            <div id="wishlistAlert" class="mt-2 text-sm hidden"></div>
            </div>
          </div>
      

          
        <!-- </form> -->

        {{-- SKU & Category --}}
        <div class="text-sm text-gray-700 space-y-1 mt-4 fs-6">
          <p><strong>SKU:</strong> {{ $product->sku ?? 'N/A' }}</p>
          <p><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
        </div>

        {{-- Secondary actions: Checkout + Continue --}}
        <div class="flex items-center gap-3 mt-6 fs-5">
          @if(auth()->check())
            <a href="{{ route('cart.checkout') }}" class="btn border px-5 py-2 rounded hover:bg-gray-50">Checkout</a>
          @else
            <a href="#" onclick="showAuth('signin')" class="border px-5 py-2 rounded hover:bg-gray-50">Checkout</a>
          @endif
          <a href="{{ route('home') }}"
            class="border px-5 py-2 rounded hover:bg-gray-50">Continue Shopping</a>
        </div>
      </div>

    </div>
</section>

<!-- Include Alpine.js (for tab switching) -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div x-data="{ tab: 'description' }" class="container mx-auto px-4 mt-10">
  <!-- Tabs -->
  <div class="border-b border-gray-300 mb-6">
    <ul class="flex gap-6 text-base font-semibold text-gray-700 fs-5">
      <li :class="tab === 'description' ? 'border-b-2 border-yellow-500 text-yellow-500' : 'hover:text-yellow-500'"
          @click="tab = 'description'" class="pb-2 cursor-pointer">Description</li>
      <li :class="tab === 'info' ? 'border-b-2 border-yellow-500 text-yellow-500' : 'hover:text-yellow-500'"
          @click="tab = 'info'" class="pb-2 cursor-pointer">Additional Info</li>
      <li :class="tab === 'reviews' ? 'border-b-2 border-yellow-500 text-yellow-500' : 'hover:text-yellow-500'"
          @click="tab = 'reviews'" class="pb-2 cursor-pointer">Customer Reviews</li>
    </ul>
  </div>

  <!-- Description Tab -->
  <div x-show="tab === 'description'" class="text-gray-700 text-[17px] leading-relaxed">
    Enjoy our California Roasted Pistachios, lightly salted for better balance.
    Packed with protein, fiber, and healthy fats, they support heart and gut health
    while adding a creamy, earthy flavor to snacks, salads, or recipes — a perfect fit
    for plant-based diets.
  </div>

  <!-- Additional Info Tab -->
  <div x-show="tab === 'info'" class="text-gray-700 text-[17px] leading-relaxed">
    <ul class="list-disc ml-5 space-y-2">
      <li>Ingredients: Roasted Pistachios, Sea Salt</li>
      <li>Storage: Keep in cool, dry place</li>
      <li>Allergy Info: Contains Tree Nuts (Pistachios)</li>
    </ul>
  </div>

  <!-- Customer Reviews Tab -->
  <div x-show="tab === 'reviews'" class="pt-8">
    
   <!-- Review Modal Wrapper -->
<div x-data="{ open: false, notAllowed: false }" x-cloak>
  <button @click="open = true" class="bg-green-600 text-white px-5 py-2 rounded-full text-sm font-medium hover:bg-green-700">
    Write a review
  </button>

  <!-- Modal Background -->
  <div 
    x-show="open" 
    x-cloak 
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    x-transition.opacity
  >
    <div class="bg-white w-full max-w-md p-6 rounded-2xl relative" x-transition.scale>
      <button @click="open = false" class="absolute right-4 top-4 text-gray-500 text-xl">&times;</button>
      
      <!-- If review not allowed -->
      <div x-show="notAllowed" x-transition>
        <h2 class="text-xl font-semibold mb-4">Review not available</h2>
        <div class="flex items-center gap-4">
          <img src="https://cdn-icons-png.flaticon.com/512/2909/2909787.png" class="w-20 h-20">
          <p class="text-gray-700 text-sm">
            Sorry, you cannot review <strong>{{ $product->name }}</strong>.<br>
            You can only review products you’ve purchased and received.<br>
            Visit your order history to review other products.
          </p>
        </div>
        <button @click="open=false" class="mt-5 bg-gray-800 text-white px-4 py-2 rounded-full">Continue Shopping</button>
      </div>

      <!-- Review Form -->
      <form x-show="!notAllowed" id="reviewForm" class="space-y-4" x-transition>
        <h2 class="text-xl font-semibold mb-3">Write a Review</h2>
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div>
          <label class="block text-sm font-medium">Name</label>
          <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>
        <div>
          <label class="block text-sm font-medium">Rating</label>
          <select name="rating" class="w-full border rounded p-2" required>
            <option value="">Select Rating</option>
            <option value="5">⭐⭐⭐⭐⭐ - Excellent</option>
            <option value="4">⭐⭐⭐⭐ - Good</option>
            <option value="3">⭐⭐⭐ - Average</option>
            <option value="2">⭐⭐ - Poor</option>
            <option value="1">⭐ - Very Bad</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium">Message</label>
          <textarea name="message" class="w-full border rounded p-2" rows="3" required></textarea>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-full w-full hover:bg-green-700">
          Submit Review
        </button>
      </form>
    </div>
  </div>
</div>


    <!-- AJAX Script -->
    <script>
    document.getElementById('reviewForm')?.addEventListener('submit', async function(e) {
      e.preventDefault();
      const formData = new FormData(this);

      const response = await fetch('{{ route("product.review.store") }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
      });

      const data = await response.json();
      if (data.not_allowed) {
        document.querySelector('[x-data]').__x.$data.notAllowed = true;
      } else if (data.success) {
        alert('✅ Review submitted successfully!');
        location.reload();
      }
    });
    </script>

    <!-- Rating Summary -->
    <div class="mb-8">
      <div class="flex items-center gap-2 mb-3">
        <span class="text-3xl font-bold">4.3</span>
        <div class="flex text-yellow-400 text-xl">
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star-half-alt"></i>
        </div>
        <span class="text-gray-600 ml-2">1,514 Ratings</span>
      </div>

      <!-- Rating Bars -->
      <div class="space-y-2">
        @php
          $ratings = [
            ['stars' => 5, 'percent' => 92.4],
            ['stars' => 4, 'percent' => 6.1],
            ['stars' => 3, 'percent' => 1.1],
            ['stars' => 2, 'percent' => 0.2],
            ['stars' => 1, 'percent' => 0.2],
          ];
        @endphp

        @foreach($ratings as $r)
        <div class="flex items-center gap-2">
          <span class="text-gray-600 w-12 text-sm">{{ $r['stars'] }} star</span>
          <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden">
            <div class="bg-yellow-400 h-3" style="width: {{ $r['percent'] }}%;"></div>
          </div>
          <span class="text-gray-500 text-sm w-12 text-right">{{ $r['percent'] }}%</span>
        </div>
        @endforeach
      </div>
    </div>

    <!-- Featured Review -->
    <div class="border-t pt-6">
      <div class="flex items-center mb-2">
        <div class="flex text-yellow-400 text-sm">
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
        </div>
        <span class="text-gray-500 text-sm ml-2">—7 days ago</span>
      </div>
      <div class="flex items-center gap-3 mb-2">
        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
             class="w-10 h-10 rounded-full border">
        <div>
          <p class="font-semibold text-gray-800">Richard, Brooklyn, New York</p>
          <p class="text-green-600 text-sm font-medium flex items-center gap-1">
            <i class="fa fa-check-circle"></i> Verified purchaser
          </p>
        </div>
      </div>
      <p class="text-gray-700 leading-relaxed mb-3">
        I have found my perfect pistachio. Purchased a cute candy dish for them. Can't keep the dish full.
        Someone keeps eating them all. Pistachios are the healthy nut choice. Remember, they are great on
        salads and ice cream!
      </p>
      <div class="flex items-center gap-3">
        <span class="text-xs bg-pink-100 text-pink-700 font-semibold px-3 py-1 rounded-full">
          Featured Review
        </span>
        <button class="flex items-center text-gray-600 text-sm border rounded-full px-3 py-1 hover:bg-gray-100">
          <i class="fa fa-thumbs-up mr-1"></i> Helpful
        </button>
        <span class="text-gray-500 text-xs ml-auto">Size: 1lb bag</span>
      </div>
    </div>
  </div>
</div>




<!-- Related Products -->
@include('frontend.components.relatedProducts', ['relatedProducts' => $relatedProducts])

@endsection

@push('scripts')
<script>
  
  document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("addToCartBtn");
    if (!btn) {
        console.warn("Add to Cart button not found");
        return;
    }

    btn.addEventListener("click", () => {
        const formData = new FormData();
        formData.append("product_id", btn.dataset.product);
        formData.append("size_id", btn.dataset.size);
        formData.append("qty", document.getElementById("qtyInput").value);

        fetch(btn.dataset.url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById("cartBadge").textContent = data.count;
                showCartOffcanvas();            

            } else {
                alert(data.message || "Failed to add to cart");
            }
        });
    });
  });

  (function(){
    const radios      = document.querySelectorAll('.sizeRadio');
    const priceEl     = document.getElementById('priceValue');
    const stockHint   = document.getElementById('stockHint');
    const sizeLabel   = document.getElementById('selectedSizeLabel');
    const qtyInput    = document.getElementById('qtyInput');
    const addBtn      = document.getElementById('addToCartBtn');
    const selectedQty = document.getElementById('selectedQty');
    const selectedId  = document.getElementById('selectedSizeId');
    const wishlistBtn = document.getElementById("wishlistBtn");

    let maxStock = 0;

    function dollars(n){ return '$' + Number(n).toFixed(2); }

    function refreshFromRadio(r){
      const price = Number(r.dataset.price || 0);
      const stock = Number(r.dataset.stock || 0);
      const label = r.dataset.label || '';
      selectedId.value = r.value;

      priceEl.textContent = dollars(price);
      stockHint.textContent = stock > 0 ? `${stock} in stock` : 'Out of stock';
      sizeLabel.textContent = label;
      maxStock = stock;

      // clamp qty and set button enabled/disabled
      const n = Math.max(1, Math.min(parseInt(qtyInput.value || '1', 10), Math.max(stock, 1)));
      qtyInput.value = n;
      selectedQty.value = n;
      addBtn.disabled = stock <= 0;
    }
    

    if (wishlistBtn) {
      wishlistBtn.addEventListener("click", function () {
        const productId = this.dataset.product;
        const sizeId = this.dataset.size;
        const icon = document.getElementById("wishlistIcon");
        const alertBox = document.getElementById("wishlistAlert");
        let itemId = this.dataset.itemId;

        const isActive = icon.classList.contains("fas");
        let url, method, body;

        if (isActive && itemId) {
          // REMOVE
          url = `/wishlist/remove/${itemId}`;
          method = "DELETE";
          body = null;
        } else {
          // ADD
          url = "{{ route('wishlist.add') }}";
          method = "POST";
          body = new URLSearchParams({ product_id: productId, size_id: sizeId });
        }

        fetch(url, {
          method,
          headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json",
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            if (method === "POST") {
              icon.classList.remove("far","text-gray-700");
              icon.classList.add("fas","text-yellow-500");
              wishlistBtn.dataset.itemId = data.id;
            } else {
              icon.classList.remove("fas","text-yellow-500");
              icon.classList.add("far","text-gray-700");
              wishlistBtn.dataset.itemId = "";
            }
            alertBox.textContent = data.message;
            alertBox.className = "mt-2 text-sm text-green-600";
            alertBox.style.display = "block";
            setTimeout(() => alertBox.style.display = "none", 3000);
          }
        })
        .catch(err => console.error("Wishlist error:", err));
      });
    }



    // init
    const current = Array.from(radios).find(r => r.checked) || radios[0];
    if (current) refreshFromRadio(current);

    // listen to change
    radios.forEach(r => r.addEventListener('change', () => refreshFromRadio(r)));

    // qty +/- (use your existing handlers)
    document.getElementById('qtyMinus').addEventListener('click', () => {
      const n = Math.max(1, parseInt(qtyInput.value || '1', 10) - 1);
      qtyInput.value = n; selectedQty.value = n;
    });
    document.getElementById('qtyPlus').addEventListener('click', () => {
      const n = Math.min(maxStock || 9999, parseInt(qtyInput.value || '1', 10) + 1);
      qtyInput.value = n; selectedQty.value = n;
    });
    qtyInput.addEventListener('input', () => {
      let n = parseInt(qtyInput.value || '1', 10);
      if (isNaN(n)) n = 1;
      n = Math.max(1, Math.min(n, maxStock || 9999));
      qtyInput.value = n; selectedQty.value = n;
    });

    // thumbnails → swap big image (you asked earlier)
    const main = document.getElementById('productMainImg');
    document.querySelectorAll('.thumb').forEach(t => {
      t.addEventListener('click', () => {
        const large = t.dataset.large;
        if (large && main) {
          main.src = large;
          document.querySelectorAll('.thumb').forEach(x => x.classList.remove('ring','ring-yellow-400'));
          t.classList.add('ring','ring-yellow-400');
        }
      });
    });
  })();

  

  // keep wishlist size in sync with selected radio
  document.querySelectorAll('.sizeRadio').forEach(r => {
    r.addEventListener('change', () => {
      const w = document.getElementById('wishSizeId');
      if (w) w.value = r.value;
    });
  });

</script>
@endpush


