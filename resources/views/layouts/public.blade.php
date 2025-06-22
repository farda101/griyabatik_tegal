<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Tambahkan baris ini untuk favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('img/griya-batik.png') }}">
        
        <title>@yield('title') - {{ config('app.name', 'Workshop Batik') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
        @stack('styles')
        {{-- Font Awesome CDN (bisa di head atau di push ke scripts) --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlalTjs/P4V9+q/k3S2C6y1i4y1tQ6k8+V5vA3r5q3r5p5q5r5s5t5u5v5w5x5y5z5A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            {{-- Sertakan navigasi publik di sini --}}
            @include('layouts.public_navigation') 

            <main>
                @yield('content')
            </main>
        </div>

        @livewireScripts
        @stack('scripts')
    </body>
</html>