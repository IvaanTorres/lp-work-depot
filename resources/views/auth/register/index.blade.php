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
    </div>

    {{-- Email --}}
    <div>
      <label for="email">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required>
    </div>

    {{-- Password --}}
    <div>
      <label for="password">Password</label>
      <input id="password" type="password" name="password" required>
    </div>

    {{-- Errors --}}
    @if ($errors->any())
      <div>{{ $errors->first() }}</div>
    @endif

    {{-- Submit --}}
    <div>
      <button type="submit">Register</button>
    </div>
  </form>
@endsection