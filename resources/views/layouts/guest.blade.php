<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Recipe Book') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

        
        <link rel="icon" href="{{ Storage::url('assets/images/logo.png') }}" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
    </head>
    <body class="font-sans text-gray-900 antialiased bg-cover bg-gradient-b from-[#fbece533] to-[#FFF] dark:bg-[#fbece533]/20">
        <x-back-to-top></x-back-to-top>
        {{ $slot }}

        @stack('script')
        
    </body>
</html>
