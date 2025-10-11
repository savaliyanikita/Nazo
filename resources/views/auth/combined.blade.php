@extends('layouts.frontend')

@section('content')
<div class="relative h-48 bg-gray-100 flex items-center justify-center">
  <h1 class="text-3xl font-bold">Sign Up / Login</h1>
</div>

<div class="bg-white py-3 border-b text-sm">
  <div class="container mx-auto px-4 text-gray-500">
    <a href="{{ route('home') }}" class="hover:underline">Home</a> /
    <span class="text-gray-800 font-medium">Sign Up / Login</span>
  </div>
</div>

<section class="py-10">
  <div class="container mx-auto px-4 grid md:grid-cols-2 gap-8">

    {{-- Login --}}
    <div class="border rounded-lg p-6 shadow-sm">
      <h2 class="text-xl font-semibold mb-4">Log in</h2>
      <p class="text-sm text-gray-500 mb-4">Log in to access all your resources</p>

      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
          <label class="text-sm font-medium">Email Address</label>
          <input type="email" name="email" class="mt-1 w-full border rounded px-3 py-2" required>
        </div>
        <div>
          <label class="text-sm font-medium">Password</label>
          <input type="password" name="password" class="mt-1 w-full border rounded px-3 py-2" required>
        </div>
        <div class="flex items-center justify-between text-sm">
          <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="remember" class="rounded border-gray-300">
            Remember me
          </label>
          <a class="text-blue-600 hover:underline" href="{{ route('password.request') }}">Lost your password?</a>
        </div>
        <button class="w-full bg-gray-900 text-white py-2 rounded">LOGIN</button>
      </form>
    </div>

    {{-- Register --}}
    <div class="border rounded-lg p-6 shadow-sm">
      <h2 class="text-xl font-semibold mb-4 text-center">NEW CUSTOMER?</h2>
      <p class="text-sm text-gray-600 text-center mb-6">
        Creating an account has many benefits: check out faster, keep more than one address, track orders and more.
      </p>
      <div class="text-center">
        <a href="{{ route('register') }}"
           class="inline-block px-6 py-3 rounded border-2 border-gray-900 hover:bg-gray-900 hover:text-white">
          Create an Account
        </a>
      </div>
    </div>

  </div>
</section>
@endsection
