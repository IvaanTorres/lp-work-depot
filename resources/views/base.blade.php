<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Moodle - @yield('title')</title>

        {{-- Icon --}}
        <link rel="icon" href="{{ asset('assets/img/logo-moodle.png') }}">

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        {{-- Alpine --}}
        {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

        {{-- JQuery --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

        {{-- TailwindCSS --}}
        <script src="https://cdn.tailwindcss.com"></script>

        {{-- Global style --}}
        <link rel="stylesheet" href="{{ asset('assets/css/tailwind.css') }}">
    </head>
    <body class="antialiased h-full">
        <div class="flex h-full">
            <div class="w-32 h-full">
                @include('partials.navbar')
            </div>
    
            <div class="h-full w-full">
                @section('content')
                @show
            </div>
        </div>
    </body>
</html>
