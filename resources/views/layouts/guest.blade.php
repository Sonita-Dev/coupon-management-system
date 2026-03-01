<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Coupon Management System') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/coupon_logo.png') }}">
        <link rel="shortcut icon" href="{{ asset('images/coupon_logo.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-slate-950 px-4 py-10">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.35),_transparent_40%),radial-gradient(circle_at_bottom,_rgba(16,185,129,0.25),_transparent_35%)]"></div>

            <div class="relative w-full max-w-md rounded-2xl border border-white/10 bg-white/95 p-8 shadow-2xl shadow-slate-950/40 backdrop-blur">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
