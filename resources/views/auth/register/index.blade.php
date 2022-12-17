@extends('base')

@section('content')
  <h1>Register</h1>

  {{-- Create register form --}}
  <form method="POST" action="{{ route('register') }}">
    @csrf

    {{-- Name --}}
    <div>
      <label for="name">Name</label>
      <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
      @error('name')
        <span>{{ $message }}</span>
      @enderror
    </div>

    {{-- Email --}}
    <div>
      <label for="email">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required>
      @error('email')
        <span>{{ $message }}</span>
      @enderror
    </div>

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
      <button type="submit">Register</button>
    </div>
  </form>
@endsection