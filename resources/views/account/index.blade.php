@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12">
  <h1 class="text-2xl font-bold mb-6">Your Account</h1>
  <p class="mb-4">Welcome, {{ auth()->user()->name ?? auth()->user()->email }} 🎉</p>
  <a href="{{ route('logout') }}"
     onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
     class="text-red-600 underline">Logout</a>

  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
  </form>
</div>
@endsection

