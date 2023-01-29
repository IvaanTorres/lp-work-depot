@extends('base')

@section('title', 'Register')


@section('content')
    <div class="flex justify-center items-center h-full w-full">
        {{-- Card --}}
        <div class="flex flex-col shadow-xl rounded-xl overflow-hidden w-[350px] h-[550px]">
            <div class="flex-inital p-10 bg-orange-500 ">
                <h3 class="text-center font-bold text-2xl text-white">Register</h3>
            </div>

            <div class="flex-auto w-full h-full">
                <form method="POST" action="{{ route('register') }}" class="p-5 flex gap-7 flex-col justify-between h-full">
                    @csrf

                    <div class="flex gap-5 flex-col">
                        {{-- Name --}}
                        <div class="flex flex-col gap-1">
                            <label class="text-sm text-gray-600" for="email">Name</label>
                            <input class="border-b-2 border-b-orange-600 outline-none py-2" id="name" type="text"
                                name="name" value="{{ old('name') }}" required autofocus placeholder="Type">
                        </div>
                        
                        {{-- Email --}}
                        <div class="flex flex-col gap-1">
                            <label class="text-sm text-gray-600" for="email">Email</label>
                            <input class="border-b-2 border-b-orange-600 outline-none py-2" id="email" type="email"
                                name="email" value="{{ old('email') }}" required autofocus placeholder="Type">
                        </div>

                        {{-- Password --}}
                        <div class="flex flex-col gap-1">
                            <label class="text-sm text-gray-600" for="password">Password</label>
                            <input class="border-b-2 border-b-orange-600 outline-none py-2" id="password" type="password"
                                name="password" required placeholder="Type">
                        </div>
                        
                        {{-- Register as teacher --}}
                        <div class="flex gap-3">
                            <label class="text-sm text-gray-600" for="is_teacher">Register as teacher?</label>
                            <input type="checkbox" name="is_teacher" id="is_teacher">
                        </div>

                        {{-- Errors --}}
                        @if ($errors->any())
                            <div class="w-full text-red-600">{{ $errors->first() }}</div>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <div class="flex">
                        <button
                            class="hover:bg-orange-600 hover:text-orange-200 mt-auto block w-full px-4 py-2 text-sm font-medium text-center bg-orange-500 text-white transition-colors duration-150 border border-transparent rounded-md active:bg-orange-600"
                            type="submit">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- @section('content')
  <h1>Register</h1>

  <form method="POST" action="{{ route('register') }}">
    @csrf

    <div>
      <label for="name">Name</label>
      <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    </div>

    <div>
      <label for="email">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required>
    </div>

    <div>
      <label for="password">Password</label>
      <input id="password" type="password" name="password" required>
    </div>

    @if ($errors->any())
      <div>{{ $errors->first() }}</div>
    @endif

    <div>
      <button type="submit">Register</button>
    </div>
  </form>
@endsection --}}