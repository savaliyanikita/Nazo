<footer class="bg-gray-900 text-center text-white py-12">
    <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-10 text-sm text-gray-300">
        
        <!-- Wholesale Shopping -->
        <div>
            <h3 class="text-lg font-semibold text-white mb-4">Wholesale Shopping</h3>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-yellow-500 transition">Shop All</a></li>
                @foreach ($categories->take(6) as $category)
                    <li><a href="{{ route('category.show', $category->slug) }}" class="hover:text-yellow-500 transition">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>

        <!-- Customer Care -->
        <div>
            <h3 class="text-lg font-semibold text-white mb-4">Customer Care</h3>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-yellow-500 transition">Sign Me Up NOW!</a></li>
                <li><a href="#" class="hover:text-yellow-500 transition">New Arrivals! *Don't Miss Out</a></li>
                <li><a href="#" class="hover:text-yellow-500 transition">Promotions *Deals *Deals *Deals</a></li>
                <li><a href="#" class="hover:text-yellow-500 transition">Best Sellers *Relax let us do the work</a></li>
                <li><a href="#" class="hover:text-yellow-500 transition">Who We Are</a></li>
            </ul>
        </div>

        <!-- Support -->
        <div>
            <h3 class="text-lg font-semibold text-white mb-4">Support</h3>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-yellow-500 transition">Contact Us</a></li>
                <li><a href="#" class="hover:text-yellow-500 transition">FAQs</a></li>
                <li><a href="#" class="hover:text-yellow-500 transition">View our Digital Catalog</a></li>
                <li><a href="#" class="hover:text-yellow-500 transition">Refund Policy</a></li>
                <li><a href="#" class="hover:text-yellow-500 transition">Terms & Conditions</a></li>
                <li><a href="#" class="hover:text-yellow-500 transition">Privacy Policy</a></li>
            </ul>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="mt-10 border-t border-gray-700 pt-6 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} <span class="text-white">Nazo Dry Fruit</span>. All rights reserved.
    </div>
</footer>
