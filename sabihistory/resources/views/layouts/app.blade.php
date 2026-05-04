<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SabiHistory - @yield('title', 'History & Strategic Studies Hub')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        .nav-link { transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease; }
        .nav-link:hover { background: rgba(59, 130, 246, 0.08); transform: translateX(2px); }
        .nav-link.active { background: rgba(59, 130, 246, 0.12); border-left: 4px solid rgb(59, 130, 246); padding-left: calc(0.75rem - 4px); }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-900 antialiased">
    <div x-data="{ sidebarOpen: false, userMenuOpen: false }" class="min-h-screen">
        <nav class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-3 py-3 lg:flex-row lg:h-16 lg:items-center lg:justify-between lg:py-0">
                    <div class="flex items-center justify-between gap-3 lg:justify-start">
                        <div class="flex items-center gap-3">
                            <button type="button" @click="sidebarOpen = true" class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 hover:bg-slate-100 lg:hidden" aria-label="Open navigation menu">
                                <i class="fas fa-bars text-lg"></i>
                            </button>
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 transition hover:opacity-80">
                                <div class="rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 p-2.5 shadow-lg shadow-blue-600/20">
                                    <i class="fas fa-book-open text-base text-white"></i>
                                </div>
                                <div class="hidden sm:block">
                                    <span class="block text-lg font-bold text-slate-900">SabiHistory</span>
                                    <p class="text-xs text-slate-500">{{ Auth::user()->is_admin ? 'Admin Panel' : 'Learning Hub' }}</p>
                                </div>
                            </a>
                        </div>

                        @auth
                            <div class="sm:hidden">
                                <button type="button" @click="userMenuOpen = !userMenuOpen" class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 hover:bg-slate-100" aria-label="Open account menu">
                                    <i class="fas fa-ellipsis-vertical"></i>
                                </button>
                            </div>
                        @endauth
                    </div>

                    <div class="flex items-center gap-3 sm:gap-4 lg:justify-end">
                        @auth
                            <form action="{{ route('materials.index') }}" method="GET" class="hidden lg:block">
                                <label class="relative block">
                                    <span class="sr-only">Search materials</span>
                                    <input type="text" name="search" placeholder="Search materials..." class="w-72 rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10">
                                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                </label>
                            </form>

                            <div class="relative ml-auto hidden sm:block" @click.outside="userMenuOpen = false">
                                <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2 rounded-xl p-2 hover:bg-slate-100 focus:outline-none focus:ring-4 focus:ring-blue-500/10">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 font-bold text-white shadow-lg shadow-blue-600/20">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div class="hidden md:block text-left">
                                        <p class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-slate-500">{{ Auth::user()->is_admin ? 'Administrator' : 'Student' }}</p>
                                    </div>
                                    <i class="fas fa-chevron-down text-xs text-slate-500"></i>
                                </button>
                                <div x-cloak x-show="userMenuOpen" x-transition class="absolute right-0 mt-2 w-56 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-900/10">
                                    <div class="border-b border-slate-200 bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-3">
                                        <p class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-slate-700 transition hover:bg-slate-50"><i class="fas fa-tachometer-alt mr-2 text-blue-600"></i> Dashboard</a>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-slate-700 transition hover:bg-slate-50"><i class="fas fa-user-circle mr-2 text-emerald-600"></i> Profile</a>
                                    @if(Auth::user()->is_admin)
                                        <a href="{{ route('admin.dashboard') }}" class="block border-t border-slate-200 px-4 py-2 text-slate-700 transition hover:bg-slate-50"><i class="fas fa-crown mr-2 text-amber-500"></i> Admin Panel</a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}" class="border-t border-slate-200">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-2 text-left text-slate-700 transition hover:bg-slate-50"><i class="fas fa-sign-out-alt mr-2 text-red-600"></i> Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="rounded-xl px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Login</a>
                            <a href="{{ route('register') }}" class="rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:from-blue-700 hover:to-indigo-700">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <div class="lg:flex">
            <div x-cloak x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-900/40 lg:hidden" @click="sidebarOpen = false"></div>

            <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-[85vw] max-w-xs -translate-x-full overflow-y-auto border-r border-slate-200 bg-white shadow-2xl shadow-slate-900/10 transition-transform duration-300 lg:sticky lg:top-16 lg:z-30 lg:block lg:h-[calc(100vh-4rem)] lg:w-72 lg:max-w-none lg:translate-x-0 lg:shadow-lg" :class="sidebarOpen ? 'translate-x-0' : ''">
                <div class="p-4 sm:p-5">
                    <div class="mb-8">
                        <h3 class="px-2 text-xs font-bold uppercase tracking-[0.2em] text-slate-500">Navigation</h3>
                        <ul class="mt-3 space-y-1">
                            <li><a @click="sidebarOpen = false" href="{{ route('dashboard') }}" class="nav-link block rounded-xl px-3 py-2.5 text-slate-700 {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fas fa-home mr-2 text-blue-600"></i> Dashboard</a></li>
                            <li><a @click="sidebarOpen = false" href="{{ route('materials.index') }}" class="nav-link block rounded-xl px-3 py-2.5 text-slate-700"><i class="fas fa-file-alt mr-2 text-emerald-600"></i> Materials</a></li>
                            <li><a @click="sidebarOpen = false" href="{{ route('past-questions.index') }}" class="nav-link block rounded-xl px-3 py-2.5 text-slate-700"><i class="fas fa-question-circle mr-2 text-violet-600"></i> Past Questions</a></li>
                            <li><a @click="sidebarOpen = false" href="{{ route('lecturers.index') }}" class="nav-link block rounded-xl px-3 py-2.5 text-slate-700"><i class="fas fa-chalkboard-user mr-2 text-orange-600"></i> Lecturers</a></li>
                            <li><a @click="sidebarOpen = false" href="{{ route('news.index') }}" class="nav-link block rounded-xl px-3 py-2.5 text-slate-700"><i class="fas fa-newspaper mr-2 text-red-600"></i> News</a></li>
                        </ul>
                    </div>

                    <div class="mb-8">
                        <h3 class="px-2 text-xs font-bold uppercase tracking-[0.2em] text-slate-500">Resources</h3>
                        <ul class="mt-3 space-y-1">
                            <li><a @click="sidebarOpen = false" href="{{ route('links') }}" class="nav-link block rounded-xl px-3 py-2.5 text-slate-700"><i class="fas fa-link mr-2 text-indigo-600"></i> Quick Links</a></li>
                            <li><a @click="sidebarOpen = false" href="{{ route('projects.index') }}" class="nav-link block rounded-xl px-3 py-2.5 text-slate-700"><i class="fas fa-graduation-cap mr-2 text-pink-600"></i> Final Year Projects</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="px-2 text-xs font-bold uppercase tracking-[0.2em] text-slate-500">Course Levels</h3>
                        <ul class="mt-3 space-y-1">
                            @foreach([100,200,300,400] as $level)
                                <li><a @click="sidebarOpen = false" href="{{ route('materials.index', ['level' => $level]) }}" class="block rounded-xl px-3 py-2.5 text-sm text-slate-600 transition hover:bg-blue-50 hover:text-blue-700"><i class="fas fa-layer-group mr-2 text-slate-400"></i> Level {{ $level }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </aside>

            <main class="min-w-0 flex-1 px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8">
                @isset($header)
                    <div class="mb-6">
                        {{ $header }}
                    </div>
                @endisset

                @if(session('success'))
                    <div class="mb-4 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 shadow-sm">
                        <i class="fas fa-check-circle text-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 flex items-center gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 shadow-sm">
                        <i class="fas fa-exclamation-circle text-lg"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset

                <footer class="mt-8 border-t border-slate-200 pt-4">
                    <p class="text-center text-sm text-slate-500">Prof Coy 2026</p>
                </footer>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>