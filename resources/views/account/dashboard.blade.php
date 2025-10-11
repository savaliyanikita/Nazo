@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
  <h1 class="text-2xl font-bold mb-4">Your Account</h1>
  <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
  <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
</div>
@endsection
