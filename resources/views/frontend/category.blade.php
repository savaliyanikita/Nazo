@extends('layouts.frontend')

@section('content')

<!-- Hero Banner -->
<div class="relative h-64 bg-cover bg-center" style="background-image: url('{{ asset('images/category-banners/' . $category->slug . '.jpg') }}')">
  <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
    <h1 class="text-white text-4xl font-extrabold">{{ $category->name }}</h1>
  </div>
</div>

<!-- Breadcrumb -->
<div class="bg-white py-3 border-b text-sm">
  <div class="container mx-auto px-4 text-gray-500">
    <a href="{{ route('home') }}" class="hover:underline">Home</a> / 
    <span class="text-gray-800 font-medium">{{ $category->name }}</span>
  </div>
</div>

<!-- Main Shop Content -->
<section class="py-12 bg-gray-50">
  <div class="container mx-auto px-4 flex flex-col lg:flex-row gap-8">

    <!-- Sidebar -->
    <aside class="w-full lg:w-1/4">
      <!-- Search -->
      <!-- <div class="mb-6">
        <input type="text" placeholder="Search here" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring" />
      </div> -->

      <!-- Category List -->
      <h3 class="text-lg font-bold mb-3">Categories</h3>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('home') }}" class="text-blue-600 font-semibold hover:underline">All</a></li>
        @foreach ($allCategories as $cat)
          <li>
            <a href="{{ route('category.show', $cat->slug) }}"
              class="hover:underline {{ $cat->id == $category->id ? 'text-black font-semibold' : 'text-gray-600' }}">
              {{ $cat->name }}
            </a>
          </li>
        @endforeach
      </ul>
    </aside>

    <!-- Product Grid -->
    <div class="w-full lg:w-3/4">
      <!-- Top Info -->
      <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <p class="text-sm text-gray-500">Showing 1–{{ $products->count() }} of {{ $products->total() }} results</p>
        <div>
          <form id="sortForm" method="GET">
            <select name="sort" id="sortSelect" class="border px-3 py-2 rounded text-sm text-gray-700" 
                    onchange="document.getElementById('sortForm').submit();">
              <option value="">Default sorting</option>
              <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
              <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
              <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
              <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: (Z-A)</option>
            </select>
          </form>
        </div>
      </div>

      @if ($products->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-6">
          @foreach ($products as $product)
            <div class="bg-white rounded shadow hover:shadow-lg transition overflow-hidden">
              <a href="{{ route('product.show', $product->slug) }}">
                <img src="{{ asset('images/products/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                <div class="p-4 text-center">
                  <h3 class="font-medium text-gray-900 truncate fs-5">{{ $product->name }}</h3>
                  @if(Auth::check())
                      <p class="text-yellow-600 font-semibold mt-1 ">${{ number_format($product->min_price, 2) }}</p>
                  @else
                  <p class="text-muted font-semibold mt-1">Login to see price</p>
                  @endif
                 
                </div>
              </a>
            </div>
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
          {{ $products->links('vendor.pagination.tailwind') }}
        </div>
      @else
        <p class="text-gray-500">No products found in this category.</p>
      @endif
    </div>
  </div>
</section>

@endsection
