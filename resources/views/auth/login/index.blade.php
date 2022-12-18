@extends('base')

@section('content')
  {{-- Create login form --}}
  <form method="POST" action="{{ route('login') }}">
    @csrf

    {{-- Email --}}
    <div>
      <label for="email">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
      @error('email')
        <span>{{ $message }}</span>
      @enderror
    </div>

    {{-- If auth, log the user info --}}
    @auth
      <p>{{ auth()->user()->name }}</p>
      <p>{{ auth()->user()->email }}</p>
    @endauth

    {{-- Password --}}
    <div>
      <label for="password">Password</label>
      <input id="password" type="password" name="password" required>
      @error('password')
        <span>{{ $message }}</span>
      @enderror
    </div>

    {{-- Submit --}}
    <div>
      <button type="submit">Login</button>
    </div>
@endsection