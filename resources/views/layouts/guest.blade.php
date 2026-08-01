<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Businos Line') }}</title>

        <link rel="icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" sizes="any">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon/favicon-16x16.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('assets/img/favicon/apple-touch-icon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="flex min-h-screen flex-col items-center justify-center bg-gray-100 px-4 py-10 sm:py-14">
            <div>
                <a href="/">
                    <x-application-logo class="h-16 w-auto" />
                </a>
            </div>

            <div class="mt-6 w-full overflow-hidden bg-white px-6 py-6 shadow-md sm:max-w-md sm:rounded-lg sm:px-8 sm:py-8">
                {{ $slot }}
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
