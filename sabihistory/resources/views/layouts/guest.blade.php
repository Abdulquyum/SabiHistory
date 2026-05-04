<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Authentication</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-br from-blue-50 via-slate-50 to-indigo-100 text-slate-900 antialiased">
        <div class="relative min-h-screen px-4 pt-6 sm:flex sm:items-center sm:justify-center sm:pt-0">
            <!-- Logo & Brand -->
            <div class="mb-8 text-center">
                <a href="/" class="inline-flex flex-col items-center">
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-600 p-3 rounded-full mb-3 shadow-lg">
                        <i class="fas fa-book-open text-white text-2xl"></i>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">SabiHistory</span>
                    <p class="text-gray-600 text-sm mt-1">History & Strategic Studies Hub</p>
                </a>
            </div>

            <!-- Auth Card -->
            <div class="w-full sm:max-w-md">
                <div class="overflow-hidden rounded-2xl bg-white shadow-2xl">
                    <!-- Header Gradient -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-2"></div>
                    
                    <div class="px-6 py-7 sm:px-8">
                        {{ $slot }}
                    </div>

                    <!-- Footer -->
                    <div class="border-t border-gray-200 bg-gray-50 px-6 py-4 sm:px-8">
                        <p class="text-center text-sm text-gray-600">
                            Prof Coy 2026
                        </p>
                    </div>
                </div>
            </div>

            <!-- Decorative elements -->
            <div class="pointer-events-none absolute top-10 left-10 hidden h-20 w-20 rounded-full bg-blue-200 opacity-70 mix-blend-multiply blur-xl animate-pulse sm:block"></div>
            <div class="pointer-events-none absolute bottom-10 right-10 hidden h-32 w-32 rounded-full bg-indigo-200 opacity-70 mix-blend-multiply blur-xl animate-pulse sm:block"></div>
        </div>
    </body>
</html>
