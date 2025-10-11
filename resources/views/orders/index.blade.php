@extends('layouts.frontend')

@section('content')
<div class="container py-5">
  <h2 class="mb-4">My Orders</h2>
  @forelse($orders as $order)
    <div class="border p-3 mb-3 bg-white shadow-sm">
      <h5>Order #{{ $order->id }} - <span class="badge bg-info">{{ ucfirst($order->status) }}</span></h5>
      <p>Total: <strong>${{ number_format($order->total,2) }}</strong></p>
      <ul>
        @foreach($order->items as $item)
          <li>{{ $item->product->name }} ({{ $item->qty }}) - ${{ number_format($item->unit_price,2) }}</li>
        @endforeach
      </ul>
    </div>
  @empty
    <p>You have no orders yet.</p>
  @endforelse
</div>
@endsection
