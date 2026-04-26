<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SabiHistory - @yield('title', 'History & Strategic Studies Hub')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        .sidebar { transition: transform 0.3s ease; }
        @media (max-width: 768px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: translateX(0); } }
        .nav-link { transition: all 0.3s ease; }
        .nav-link:hover { background: rgba(59, 130, 246, 0.1); padding-left: 1.5rem; }
        .nav-link.active { background: rgba(59, 130, 246, 0.15); border-left: 4px solid rgb(59, 130, 246); }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Top Navigation -->
    <nav class="bg-white shadow-md border-b-2 border-blue-600 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center gap-3">
                    <button id="sidebarToggle" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        <div class="bg-gradient-to-br from-blue-600 to-indigo-600 p-2 rounded-lg shadow-lg">
                            <i class="fas fa-book-open text-white text-lg"></i>
                        </div>
                        <div class="hidden sm:block">
                            <span class="font-bold text-lg text-gray-900">SabiHistory</span>
                            <p class="text-xs text-gray-500">{{ Auth::user()->is_admin ? 'Admin Panel' : 'Learning Hub' }}</p>
                        </div>
                    </a>
                </div>

                <!-- Search & Actions -->
                <div class="flex items-center gap-4">
                    @auth
                        <form action="{{ route('materials.index') }}" method="GET" class="hidden md:flex items-center">
                            <div class="relative">
                                <input type="text" name="search" placeholder="Search materials..." class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 w-64">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </form>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 focus:outline-none">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-lg">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->is_admin ? 'Administrator' : 'Student' }}</p>
                                </div>
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl z-50 border border-gray-200 overflow-hidden">
                                <div class="px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 transition"><i class="fas fa-tachometer-alt mr-2 text-blue-600"></i> Dashboard</a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 transition"><i class="fas fa-user-circle mr-2 text-green-600"></i> Profile</a>
                                @auth
                                    @if(Auth::user()->is_admin)
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 transition border-t border-gray-200"><i class="fas fa-crown mr-2 text-yellow-600"></i> Admin Panel</a>
                                    @endif
                                @endauth
                                <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-200">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-50 transition"><i class="fas fa-sign-out-alt mr-2 text-red-600"></i> Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:shadow-lg transition">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar w-64 bg-white shadow-lg h-[calc(100vh-64px)] sticky top-16 overflow-y-auto border-r-2 border-gray-200 z-30">
            <div class="p-4">
                <!-- Main Navigation -->
                <div class="mb-8">
                    <h3 class="font-bold text-gray-700 mb-3 text-sm uppercase tracking-wide px-2">Navigation</h3>
                    <ul class="space-y-1">
                        <li><a href="{{ route('dashboard') }}" class="nav-link block py-2 px-3 rounded-lg text-gray-700 {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fas fa-home mr-2 text-blue-600"></i> Dashboard</a></li>
                        <li><a href="{{ route('materials.index') }}" class="nav-link block py-2 px-3 rounded-lg text-gray-700"><i class="fas fa-file-alt mr-2 text-green-600"></i> Materials</a></li>
                        <li><a href="{{ route('past-questions.index') }}" class="nav-link block py-2 px-3 rounded-lg text-gray-700"><i class="fas fa-question-circle mr-2 text-purple-600"></i> Past Questions</a></li>
                        <li><a href="{{ route('lecturers.index') }}" class="nav-link block py-2 px-3 rounded-lg text-gray-700"><i class="fas fa-chalkboard-user mr-2 text-orange-600"></i> Lecturers</a></li>
                        <li><a href="{{ route('news.index') }}" class="nav-link block py-2 px-3 rounded-lg text-gray-700"><i class="fas fa-newspaper mr-2 text-red-600"></i> News</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div class="mb-8">
                    <h3 class="font-bold text-gray-700 mb-3 text-sm uppercase tracking-wide px-2">Resources</h3>
                    <ul class="space-y-1">
                        <li><a href="{{ route('links') }}" class="nav-link block py-2 px-3 rounded-lg text-gray-700"><i class="fas fa-link mr-2 text-indigo-600"></i> Quick Links</a></li>
                        <li><a href="{{ route('projects.index') }}" class="nav-link block py-2 px-3 rounded-lg text-gray-700"><i class="fas fa-graduation-cap mr-2 text-pink-600"></i> Final Year Projects</a></li>
                    </ul>
                </div>

                <!-- Level Filter -->
                <div>
                    <h3 class="font-bold text-gray-700 mb-3 text-sm uppercase tracking-wide px-2">Course Levels</h3>
                    <ul class="space-y-1">
                        @foreach([100,200,300,400] as $level)
                            <li><a href="{{ route('materials.index', ['level' => $level]) }}" class="block py-2 px-3 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition"><i class="fas fa-layer-group mr-2"></i> Level {{ $level }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-y-auto">
            @isset($header)
                <div class="mb-6">
                    {{ $header }}
                </div>
            @endisset

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-300 text-green-800 rounded-lg flex items-center gap-3 animate-slide-down">
                    <i class="fas fa-check-circle text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-300 text-red-800 rounded-lg flex items-center gap-3 animate-slide-down">
                    <i class="fas fa-exclamation-circle text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            
            <!-- Page Content -->
            @isset($slot)
                {{ $slot }}
            @else
                @yield('content')
            @endisset
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('open');
        });
        
        // Close sidebar on small screens when a link is clicked
        document.querySelectorAll('.sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    document.getElementById('sidebar').classList.remove('open');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>