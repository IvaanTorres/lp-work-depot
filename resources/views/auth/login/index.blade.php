@extends('base')

@section('title', 'Login')

@section('content')
    <div class="flex justify-center items-center h-full w-full">
        {{-- Card --}}
        <div class="flex flex-col shadow-xl rounded-xl overflow-hidden w-[350px] h-[450px]">
            <div class="flex-inital p-10 bg-orange-500 ">
                <h3 class="text-center font-bold text-2xl text-white">Login</h3>
            </div>

            <div class="flex-auto w-full h-full">
                <form method="POST" action="{{ route('login') }}" class="p-5 flex gap-7 flex-col justify-between h-full">
                    @csrf

                    <div class="flex gap-5 flex-col">
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

                        {{-- Errors --}}
                        @if ($errors->any())
                            <div class="w-full text-red-600">{{ $errors->first() }}</div>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <div class="flex">
                        <button
                            class="hover:bg-orange-600 hover:text-orange-200 mt-auto block w-full px-4 py-2 text-sm font-medium text-center bg-orange-500 text-white transition-colors duration-150 border border-transparent rounded-md active:bg-orange-600"
                            type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
