@extends('layouts.frontend')

@section('content')
<!-- Swiper Hero Slider -->
<div class="w-full">
  <div class="swiper hero-swiper">
    <div class="swiper-wrapper" style="height: auto !important;">

      <!-- Slide 1 -->
      <div class="swiper-slide">
        <div class="relative h-[400px] bg-cover bg-center" style="background-image: url('{{ asset('images/slider1.jpg') }}')">
          <div class="absolute inset-0 bg-black/40 flex flex-col justify-center items-center text-white text-center px-4">
            <p class="text-4xl font-bold mb-4">Premium Wholesale Dry Fruits</p>
            <p class="mb-4 fs-4">Best Quality · Direct from Source · Reliable Supply</p>
            <a href="#" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded fs-4">Shop Now</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Navigation -->
    <!-- <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div> -->
  </div>
</div>

<!-- Feature Scroll Bar -->
<div class="relative overflow-hidden bg-gray-900 text-white py-6">
  <!-- Marquee container with custom animation -->
  <div class="marquee-track flex gap-[12rem] animate-marquee scroll-smooth">
    
    <!-- Loop Items TWICE for seamless effect -->
    @for ($i = 0; $i < 2; $i++)
      @foreach ([
        ['icon' => 'globe-americas', 'title' => 'Global Sourcing', 'desc' => 'Local Distribution'],
        ['icon' => 'star', 'title' => 'Premium Quality', 'desc' => ''],
        ['icon' => 'tags', 'title' => 'Competitive Pricing', 'desc' => 'Guarantee'],
        ['icon' => 'clock', 'title' => 'Order Online', 'desc' => '24/7'],
      ] as $item)
        <div class="flex flex-col items-center min-w-[160px] sm:min-w-[180px] md:min-w-[200px]">
          <i class="fas fa-{{ $item['icon'] }} text-xl sm:text-2xl md:text-3xl"></i>
          <span class="font-semibold fs-5">{{ $item['title'] }}</span>
          @if ($item['desc'])
            <span class="font-semibold text-s text-gray-300">{{ $item['desc'] }}</span>
          @endif
        </div>
      @endforeach
    @endfor

  </div>
</div>

<!-- Shop by Categories -->
<!-- Shop by Categories (Static Grid, 4 per row) -->
<section class="py-16 bg-white">
  <div class="container mx-auto text-center">
    <h2 class="text-2xl font-bold mb-10 fs-1">Shop By Category</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 px-4">
      @foreach ($categories as $category)
        <a href="{{ route('category.show', $category->slug) }}" 
           class="block border p-4 rounded hover:shadow-md transition text-center">
          <img src="{{ asset('images/category/' . $category->image) }}" 
               alt="{{ $category->name }}" 
               class="mb-2 h-32 w-full object-cover rounded">
          <p class="text-gray-800 truncate fs-5 font-semibold">{{ $category->name }}</p>
        </a>
      @endforeach
    </div>
  </div>
</section>


<!-- New Arrivals Section -->
<section class="bg-blue-50 py-12 relative overflow-hidden">
  <div class="container mx-auto px-4">
    
    <h2 class="text-2xl sm:text-3xl font-bold mb-10 text-center text-gray-800 fs-1">
      New Arrivals
    </h2>

    <!-- Scrollable or Grid Product List -->
    <div class="relative">
      <!-- Left Arrow -->
      <button id="new-arrivals-left" 
              class="absolute left-0 top-1/2 -translate-y-1/2 z-10 
                     bg-white p-2 rounded-full shadow hover:bg-gray-100 
                     lg:hidden">
        <i class="fas fa-chevron-left text-gray-600"></i>
      </button>

      <!-- Product List -->
      <div id="new-arrivals-scroll" 
           class="flex overflow-x-auto gap-6 px-6 scroll-smooth hide-scrollbar 
                  lg:grid lg:grid-cols-5 lg:gap-8 lg:overflow-x-hidden">
        @foreach ($newArrivals as $product)
          <div class="min-w-[220px] bg-white rounded-xl shadow hover:shadow-lg transition duration-300">
            <a href="{{ route('product.show', $product->slug) }}">
              <img src="{{ asset('images/products/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}"
                   class="rounded-t-xl w-full h-40 object-cover">
              <div class="p-4 text-center">
                <h3 class="text-gray-800 truncate fs-5 font-semibold">{{ $product->name }}</h3>
                @if(Auth::check())
                <p class="text-yellow-600 font-semibold mt-1">${{ number_format($product->min_price, 2) }}</p>
                @else
                <p class="text-yellow-600 font-semibold mt-1">Login to see Price</p>
                @endif 
              </div>
            </a>
          </div>
        @endforeach
      </div>

      <!-- Right Arrow -->
      <button id="new-arrivals-right" 
              class="absolute right-0 top-1/2 -translate-y-1/2 z-10 
                     bg-white p-2 rounded-full shadow hover:bg-gray-100 
                     lg:hidden">
        <i class="fas fa-chevron-right text-gray-600"></i>
      </button>
    </div>
  </div>
</section>


<!-- Business Overview -->
<section class="bg-gray-50 py-12">
  <div class="container mx-auto px-4 max-w-6xl text-center">
    <h2 class="text-3xl sm:text-3xl font-bold mb-10 text-gray-900">NAZO Products Wholesale — Where quality meets taste.</h2>

    <p class="text-m m:text-base text-gray-900 leading-relaxed mb-8">
      At <strong>NAZO Products Wholesale</strong>, we specialize in providing premium-quality dried fruits and nuts, carefully sourced from trusted international growers. Based in Long Island, we supply nationwide retailers with a wide variety of delicious, foreign-sourced products that meet the highest standards in taste, freshness, and consistency.
      <br><br>
      With a commitment to quality and reliability, NAZO is the trusted wholesale partner for grocery stores, specialty markets, and health-focused retailers who demand excellence in every bite. Our selection includes everything from classic staples to unique, hard-to-find varieties — all handpicked for their superior flavor and shelf appeal.
      <br><br>
      We’re passionate about bringing the world’s best to your shelves — so your customers keep coming back for more.<br>
      
    </p>
    <a href="#" 
       class="inline-block px-5 py-2 border border-[#000] text-gray-900 text-sm font-medium rounded hover:bg-gray-900 hover:text-white transition fs-5">
      All Products
    </a>
  </div>
</section>

<!-- Best Selling Products -->
<section class=" py-12">
  <div class="container mx-auto px-4">
    <h2 class="text-2xl sm:text-3xl font-bold text-center mb-10 fs-1">Best Selling Products</h2>
    
    <!-- Scrollable on mobile, grid on larger -->
    <div class="flex overflow-x-auto gap-4 sm:grid sm:grid-cols-3 lg:grid-cols-5 hide-scrollbar">
      @foreach ($newArrivals->take(5) as $product)
        <div class="min-w-[200px] sm:min-w-0 border border-gray-300 hover:shadow-lg transition rounded-lg overflow-hidden bg-white">
          <a href="#">
            <img src="{{ asset('images/products/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-36 object-cover">
            <div class="p-4 text-center">
              <div class="text-yellow-500 mb-1">
                @for ($i = 0; $i < 5; $i++)
                  <i class="fas fa-star"></i>
                @endfor
              </div>
              <h3 class="font-semibold text-gray-800 truncate fs-5">{{ $product->name }}</h3>
            </div>
          </a>
        </div>
      @endforeach
    </div>

  </div>
</section>

<section class="py-16 bg-gray-100">
  <div class="container mx-auto px-4 text-center">
    <h2 class="text-2xl font-bold mb-10">What Our Customers Say</h2>

    <!-- Scroll Container -->
    <div class="relative overflow-hidden">
      <div id="review-scroll" class="flex transition-all duration-500 ease-in-out" style="transform: translateX(0);">
        @foreach($googleReviews as $review)
          <div class="w-full sm:w-1/2 lg:w-1/3 px-3 shrink-0">
            <div class="bg-white p-6 rounded shadow h-full">
              <p class="italic text-gray-700">“{{ $review['text'] }}”</p>
              <p class="mt-4 font-semibold text-gray-900">- {{ $review['author'] }}</p>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Nav Buttons -->
      <button id="review-left" class="absolute left-0 top-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-200 z-10">
        <i class="fas fa-chevron-left text-gray-600"></i>
      </button>
      <button id="review-right" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-200 z-10">
        <i class="fas fa-chevron-right text-gray-600"></i>
      </button>
    </div>

    <!-- Dots -->
    <div class="flex justify-center mt-6 gap-2" id="review-dots">
      @php $dotCount = ceil(count($googleReviews) / 3); @endphp
      @for($i = 0; $i < $dotCount; $i++)
        <span class="w-3 h-3 rounded-full bg-gray-300 hover:bg-yellow-500 cursor-pointer transition" data-index="{{ $i }}"></span>
      @endfor
    </div>
  </div>
</section>


@endsection

<script>
  const scrollBox = document.getElementById('new-arrivals-scroll');
  const leftBtn = document.getElementById('new-arrivals-left');
  const rightBtn = document.getElementById('new-arrivals-right');

  // Manual scroll
  leftBtn.onclick = () => scrollBox.scrollBy({ left: -250, behavior: 'smooth' });
  rightBtn.onclick = () => scrollBox.scrollBy({ left: 250, behavior: 'smooth' });

  // Auto-scroll (mobile only)
  let autoScroll;
  function setupAutoScroll() {
    clearInterval(autoScroll);
    if (window.innerWidth < 1024) {
      autoScroll = setInterval(() => {
        scrollBox.scrollBy({ left: 250, behavior: 'smooth' });
      }, 3000);
    }
  }

  setupAutoScroll();
  window.addEventListener('resize', setupAutoScroll);
    
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const reviewscrollBox = document.getElementById('review-scroll');
  const reviewleftBtn = document.getElementById('review-left');
  const reviewrightBtn = document.getElementById('review-right');
  const dots = document.querySelectorAll('#review-dots span');

  const cardWidth = reviewscrollBox.clientWidth / 3;
  const totalCards = reviewscrollBox.children.length;
  const maxIndex = Math.ceil(totalCards / 3) - 1;
  let currentIndex = 0;

  function updateScroll() {
    reviewscrollBox.style.transform = `translateX(-${currentIndex * 100}%)`;
    dots.forEach(dot => dot.classList.remove('bg-yellow-500'));
    if (dots[currentIndex]) dots[currentIndex].classList.add('bg-yellow-500');
  }

  reviewleftBtn.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + (maxIndex + 1)) % (maxIndex + 1);
    updateScroll();
  });

  reviewrightBtn.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % (maxIndex + 1);
    updateScroll();
  });

  dots.forEach(dot => {
    dot.addEventListener('click', () => {
      currentIndex = parseInt(dot.dataset.index);
      updateScroll();
    });
  });

  // Auto scroll every 5s
  setInterval(() => {
    currentIndex = (currentIndex + 1) % (maxIndex + 1);
    updateScroll();
  }, 5000);

  updateScroll();
});
</script>


