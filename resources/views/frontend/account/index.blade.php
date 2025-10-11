@extends('layouts.frontend')

@section('content')
<!-- My Account Banner -->
<div class="relative h-64 bg-cover bg-center" style="background-image: url('{{ asset('images/slider1.jpg') }}')">
  <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
    <h1 class="text-white text-4xl font-extrabold">My Account</h1>
  </div>
</div>
<!-- Breadcrumb -->
<div class="bg-white py-3 border-b text-sm">
  <div class="container mx-auto px-4 text-gray-500">
    <a href="{{ route('home') }}" class="hover:underline">Home</a> /
    <span class="text-gray-800 font-medium">My Account</span>
  </div>
</div>
<div class="container my-5">
    <div class="row">
        <div class="col-md-3">
            @include('frontend.components.accountSidebar')
        </div>
        <div class="col-md-9">
            <h2 class="fw-bold">Welcome back, {{ auth()->user()->name }}</h2>
            <p class="text-muted">Email: {{ auth()->user()->email }}</p>
            <p class="text-muted">Here you can manage your orders, wishlist, and account settings.</p>
        </div>

    </div>
</div>
@endsection
