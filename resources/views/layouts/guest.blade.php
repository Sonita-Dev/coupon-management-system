<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CouponHub') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased min-h-screen bg-gray-50">
        <div class="min-h-screen flex">
            <!-- Left branding panel (desktop only) -->
            <div class="hidden lg:flex lg:flex-col lg:w-1/2 bg-indigo-700 text-white p-12 relative overflow-hidden">
                <!-- Decorative background circles -->
                <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-600 rounded-full opacity-40"></div>
                <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-indigo-800 rounded-full opacity-40"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-indigo-500 rounded-full opacity-20"></div>

                <!-- Logo & app name -->
                <div class="relative z-10 flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight">{{ config('app.name', 'CouponHub') }}</span>
                </div>

                <!-- Hero text -->
                <div class="relative z-10 mt-auto">
                    <h1 class="text-4xl font-bold leading-tight mb-4">
                        Manage Coupons<br>with Confidence
                    </h1>
                    <p class="text-indigo-200 text-lg leading-relaxed">
                        Create, track, and validate discount coupons — all from one powerful dashboard.
                    </p>
                </div>

                <!-- Feature badges -->
                <div class="relative z-10 mt-10 grid grid-cols-3 gap-4">
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold">%</div>
                        <div class="text-xs text-indigo-200 mt-1 font-medium">Percentage</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold">RM</div>
                        <div class="text-xs text-indigo-200 mt-1 font-medium">Fixed Amount</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold">&#10003;</div>
                        <div class="text-xs text-indigo-200 mt-1 font-medium">Validation</div>
                    </div>
                </div>
            </div>

            <!-- Right form panel -->
            <div class="flex-1 flex flex-col items-center justify-center p-8 sm:p-12">
                <!-- Mobile logo -->
                <div class="lg:hidden flex items-center gap-2 mb-10">
                    <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-gray-900">{{ config('app.name', 'CouponHub') }}</span>
                </div>

                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
