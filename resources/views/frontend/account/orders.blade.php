@extends('layouts.frontend')

@section('content')
<!-- Order History Banner -->
<div class="relative h-64 bg-cover bg-center" style="background-image: url('{{ asset('images/slider1.jpg') }}')">
  <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
    <h1 class="text-white text-4xl font-extrabold">Order History</h1>
  </div>
</div>
<!-- Breadcrumb -->
<div class="bg-white py-3 border-b text-sm">
  <div class="container mx-auto px-4 text-gray-500">
    <a href="{{ route('home') }}" class="hover:underline">Home</a> /
    <span class="text-gray-800 font-medium">Order History</span>
  </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-md-3">
            @include('frontend.components.accountSidebar')
        </div>
        <div class="col-md-9">
            <h2 class="mb-4">Order History</h2>

            @if($orders->count())
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">You have no orders yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection
