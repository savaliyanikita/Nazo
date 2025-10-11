@extends('layouts.frontend')

@section('content')
<div class="relative h-64 bg-cover bg-center" style="background-image: url('{{ asset('images/slider1.jpg') }}')">
  <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
    <h1 class="text-white text-4xl font-extrabold">Thank You</h1>
  </div>
</div>
<!-- Breadcrumb -->
<div class="bg-white py-3 border-b text-sm">
  <div class="container mx-auto px-4 text-gray-500">
    <a href="{{ route('home') }}" class="hover:underline">Home</a> /
    <span class="text-gray-800 font-medium">Thank You</span>
  </div>
</div>


<div class="container my-5 text-center">
    <h1 class="fw-bold mb-4 text-success" style="font-size: 2.5rem;">
        Thank you for your order!
    </h1>
    <p class="lead mb-3" style="line-height: 1.8;">
        We're <strong class="text-warning fw-semibold">nazo</strong> about great customers like you and truly appreciate your support.
    </p>
    <p class="lead mb-3" style="line-height: 1.8;">
        Your order is being carefully packed and will be on its way shortly.
    </p>
    <p class="lead" style="line-height: 1.8;">
        If you have any questions or need assistance, feel free to reach out — we’re always happy to help!
    </p>
    <a href="{{ route('home') }}" class="btn btn-warning mt-3 fw-bold text-white bg-yellow-500 hover:bg-yellow-600">Continue Shopping</a>
</div>
@endsection
