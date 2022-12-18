<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Moodle - @yield('title')</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- AlpineJS --}}
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        {{-- JQuery --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        {{-- Dynamic assets and metadata --}}
        @yield('head')
        @yield('alpine')
        <script rel="text/javascript" src="{{ URL::asset('/js/app.js') }}"></script>
        @livewireStyles
    </head>
    <body class="antialiased">
        @include('partials.navbar')

        @yield('content')
        @livewireScripts
    </body>
</html>
