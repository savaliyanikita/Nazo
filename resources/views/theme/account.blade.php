@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-12 gap-8">
        
        <!-- Sidebar -->
        <div class="col-span-12 md:col-span-3">
            <div class="bg-white shadow rounded-lg p-4">
                <ul class="space-y-2 text-[15px] font-medium text-gray-700">
                    <li><a href="#" class="block py-2 hover:text-[#0b6efb]">Your Account</a></li>
                    <li><a href="#" class="block py-2 hover:text-[#0b6efb]">Easy Reorder</a></li>
                    <li><a href="#" class="block py-2 hover:text-[#0b6efb]">Order History</a></li>
                    <li><a href="#" class="block py-2 hover:text-[#0b6efb]">Subscriptions</a></li>
                    <li><a href="#" class="block py-2 hover:text-[#0b6efb]">Wallet</a></li>
                    <li><a href="#" class="block py-2 hover:text-[#0b6efb]">Address Book</a></li>
                    <li><a href="#" class="block py-2 hover:text-[#0b6efb]">Email Communications</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-span-12 md:col-span-9">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4">Your Information</h2>
                <p class="text-gray-700"><strong>Name:</strong> {{ Auth::user()->name }}</p>
                <p class="text-gray-700"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <a href="#" class="text-sm text-[#0b6efb] underline">Change Email Address</a> |
                <a href="#" class="text-sm text-[#0b6efb] underline">Change Password</a>

                <hr class="my-6">

                <h2 class="text-2xl font-semibold mb-4">Recent Orders</h2>
                @if(Auth::user()->orders && Auth::user()->orders->count())
                    <ul class="space-y-4">
                        @foreach(Auth::user()->orders as $order)
                            <li class="border-b pb-2">
                                <p class="text-gray-800">Order #{{ $order->id }} - {{ $order->created_at->format('M d, Y') }}</p>
                                <p class="text-sm text-gray-600">Total: ${{ $order->total }}</p>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-600">You haven't placed any orders yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
