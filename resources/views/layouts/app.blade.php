<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="icon" type="image/x-icon" href="{{ Storage::url('assets/images/logo.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('style')
        @stack('headerScript')
    </head>
    <body class="font-sans text-gray-900 antialiased bg-cover bg-gradient-b from-[#fbece533] to-[#FFF] dark:bg-[#fbece533]/20 " >
        
        <!-- Page Content -->
        <div class="bg-[--primary]">
            @include('layouts.navigation')
        </div>

        <x-back-to-top></x-back-to-top>
        
        {{ $slot }}
        @stack('script')

    </body>
</html>
