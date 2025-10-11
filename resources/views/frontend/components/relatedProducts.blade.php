<div class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-xl sm:text-2xl font-bold mb-8">Related Products</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach ($relatedProducts as $item)
                <div class="border rounded-lg p-3 hover:shadow-md transition bg-white">
                    <a href="{{ route('product.show', $item->slug) }}">
                        
                        <img src="{{ asset('images/products/' . $item->images->first()->image_path) }}" alt="{{ $item->name }}" class="w-full h-40 object-cover rounded">
                        <h3 class="mt-3 text-sm font-semibold text-gray-800 fs-5">{{ $item->name }}</h3>
                        <p class="text-yellow-500 font-semibold">${{ number_format($item->min_price, 2) }}</p>
                    </a>

                    <form action="#" method="POST" class="mt-2">
                        @csrf
                        <button class="w-full bg-yellow-500 text-white text-sm py-2 rounded hover:bg-yellow-600 transition">
                            Add to Cart
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>
