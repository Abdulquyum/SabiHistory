<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - SabiHistory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .nav-link { transition: all 0.3s ease; }
        .nav-link:hover { background: rgba(255, 255, 255, 0.1); transform: translateX(4px); }
        .nav-link.active { background: rgba(255, 255, 255, 0.15); border-left: 4px solid rgb(255, 255, 255); padding-left: calc(0.75rem - 4px); }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 text-white flex flex-col shadow-2xl">
            <!-- Header -->
            <div class="p-6 border-b border-gray-700">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 mb-4">
                    <div class="bg-gradient-to-br from-blue-400 to-blue-600 p-2 rounded-lg shadow-lg">
                        <i class="fas fa-crown text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold">Admin Panel</h1>
                        <p class="text-xs text-gray-400">SabiHistory Control</p>
                    </div>
                </a>
                <div class="bg-gray-700 rounded-lg p-3 text-sm">
                    <p class="text-gray-300">Welcome,</p>
                    <p class="font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <div class="mb-6">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider px-3 mb-3">Management</p>
                    <a href="{{ route('admin.dashboard') }}" class="nav-link block py-2 px-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line mr-2 text-blue-400"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.users') }}" class="nav-link block py-2 px-3 rounded-lg {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="fas fa-users mr-2 text-green-400"></i> Users
                    </a>
                    <a href="{{ route('admin.materials') }}" class="nav-link block py-2 px-3 rounded-lg {{ request()->routeIs('admin.materials*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt mr-2 text-purple-400"></i> Materials
                    </a>
                    <a href="{{ route('admin.projects.index') }}" class="nav-link block py-2 px-3 rounded-lg {{ request()->routeIs('admin.projects*') ? 'active' : '' }}">
                        <i class="fas fa-graduation-cap mr-2 text-emerald-400"></i> Projects
                    </a>
                    <a href="{{ route('admin.news') }}" class="nav-link block py-2 px-3 rounded-lg {{ request()->routeIs('admin.news*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper mr-2 text-red-400"></i> News
                    </a>
                    <a href="{{ route('admin.courses') }}" class="nav-link block py-2 px-3 rounded-lg {{ request()->routeIs('admin.courses*') ? 'active' : '' }}">
                        <i class="fas fa-book mr-2 text-orange-400"></i> Courses
                    </a>
                    <a href="{{ route('admin.lecturers') }}" class="nav-link block py-2 px-3 rounded-lg {{ request()->routeIs('admin.lecturers*') ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-user mr-2 text-pink-400"></i> Lecturers
                    </a>
                </div>

                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider px-3 mb-3">Settings</p>
                    <a href="{{ route('admin.settings') }}" class="nav-link block py-2 px-3 rounded-lg {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <i class="fas fa-cog mr-2 text-yellow-400"></i> Settings
                    </a>
                </div>
            </nav>

            <!-- Footer -->
            <div class="p-4 border-t border-gray-700 space-y-2">
                <a href="{{ route('dashboard') }}" class="nav-link block py-2 px-3 rounded-lg">
                    <i class="fas fa-globe mr-2 text-cyan-400"></i> View Site
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link w-full text-left py-2 px-3 rounded-lg hover:bg-red-600/20">
                        <i class="fas fa-sign-out-alt mr-2 text-red-400"></i> Logout
                    </button>
                </form>
                <div class="text-xs text-gray-500 text-center pt-2 border-t border-gray-700">
                    Prof Coy 2026
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto flex flex-col">
            <!-- Top Bar -->
            <header class="bg-white shadow-md border-b-2 border-blue-600 p-6 sticky top-0 z-20">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">@yield('title', 'Dashboard')</h1>
                        <p class="text-gray-600 text-sm mt-1">Manage your platform resources</p>
                    </div>
                    <div class="text-right text-gray-600 text-sm">
                        <p class="font-semibold">{{ now()->format('l, F j, Y') }}</p>
                        <p>{{ now()->format('H:i') }}</p>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="flex-1 p-6">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg flex items-center gap-3 animate-pulse">
                        <i class="fas fa-check-circle text-lg"></i>
                        <div>
                            <p class="font-semibold">Success!</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-lg flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-lg"></i>
                        <div>
                            <p class="font-semibold">Error!</p>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>