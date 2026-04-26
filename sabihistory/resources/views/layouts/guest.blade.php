<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-blue-50 via-blue-100 to-indigo-100">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
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
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                    <!-- Header Gradient -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-2"></div>
                    
                    <div class="px-8 py-8">
                        {{ $slot }}
                    </div>

                    <!-- Footer -->
                    <div class="px-8 py-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-center text-sm text-gray-600">
                            SabiHistory © {{ date('Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Decorative elements -->
            <div class="absolute top-10 left-10 w-20 h-20 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-32 h-32 bg-indigo-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
        </div>
    </body>
</html>
