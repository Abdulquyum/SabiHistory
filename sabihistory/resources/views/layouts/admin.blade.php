<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - SabiHistory</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        .nav-link { transition: background-color 0.2s ease, transform 0.2s ease; }
        .nav-link:hover { background: rgba(255, 255, 255, 0.08); transform: translateX(2px); }
        .nav-link.active { background: rgba(255, 255, 255, 0.14); border-left: 4px solid rgb(255, 255, 255); padding-left: calc(0.75rem - 4px); }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 antialiased">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <div x-cloak x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-900/40 lg:hidden" @click="sidebarOpen = false"></div>

        <div class="lg:flex">
            <!-- Sidebar -->
            <aside
                class="fixed inset-y-0 left-0 z-50 w-[85vw] max-w-xs -translate-x-full overflow-y-auto bg-slate-950 text-white shadow-2xl shadow-slate-900/30 transition-transform duration-300 lg:sticky lg:top-0 lg:z-30 lg:block lg:h-screen lg:w-64 lg:max-w-none lg:translate-x-0"
                :class="sidebarOpen ? 'translate-x-0' : ''"
            >
                <div class="flex h-full flex-col">
                    <header class="border-b border-white/10 p-5">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                            <div class="rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 p-2.5 shadow-lg shadow-blue-500/20">
                                <i class="fas fa-crown text-lg"></i>
                            </div>
                            <div>
                                <h1 class="text-lg font-bold">Admin Panel</h1>
                                <p class="text-xs text-slate-400">SabiHistory Control</p>
                            </div>
                        </a>
                        <div class="mt-4 rounded-2xl bg-white/10 p-3 text-sm">
                            <p class="text-slate-300">Welcome,</p>
                            <p class="truncate font-semibold text-white">{{ Auth::user()->name }}</p>
                        </div>
                    </header>

                    <nav class="flex-1 space-y-2 overflow-y-auto p-4">
                        <div class="mb-6">
                            <p class="px-3 mb-3 text-xs font-bold uppercase tracking-wider text-slate-400">Management</p>
                            <a @click="sidebarOpen = false" href="{{ route('admin.dashboard') }}" class="nav-link block rounded-xl px-3 py-2.5 text-white/80 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-chart-line mr-2 text-blue-400"></i> Dashboard</a>
                            <a @click="sidebarOpen = false" href="{{ route('admin.users') }}" class="nav-link block rounded-xl px-3 py-2.5 text-white/80 {{ request()->routeIs('admin.users*') ? 'active' : '' }}"><i class="fas fa-users mr-2 text-green-400"></i> Users</a>
                            <a @click="sidebarOpen = false" href="{{ route('admin.materials') }}" class="nav-link block rounded-xl px-3 py-2.5 text-white/80 {{ request()->routeIs('admin.materials*') ? 'active' : '' }}"><i class="fas fa-file-alt mr-2 text-purple-400"></i> Materials</a>
                            <a @click="sidebarOpen = false" href="{{ route('admin.projects.index') }}" class="nav-link block rounded-xl px-3 py-2.5 text-white/80 {{ request()->routeIs('admin.projects*') ? 'active' : '' }}"><i class="fas fa-graduation-cap mr-2 text-emerald-400"></i> Projects</a>
                            <a @click="sidebarOpen = false" href="{{ route('admin.news') }}" class="nav-link block rounded-xl px-3 py-2.5 text-white/80 {{ request()->routeIs('admin.news*') ? 'active' : '' }}"><i class="fas fa-newspaper mr-2 text-red-400"></i> News</a>
                            <a @click="sidebarOpen = false" href="{{ route('admin.courses') }}" class="nav-link block rounded-xl px-3 py-2.5 text-white/80 {{ request()->routeIs('admin.courses*') ? 'active' : '' }}"><i class="fas fa-book mr-2 text-orange-400"></i> Courses</a>
                            <a @click="sidebarOpen = false" href="{{ route('admin.lecturers') }}" class="nav-link block rounded-xl px-3 py-2.5 text-white/80 {{ request()->routeIs('admin.lecturers*') ? 'active' : '' }}"><i class="fas fa-chalkboard-user mr-2 text-pink-400"></i> Lecturers</a>
                        </div>

                        <div>
                            <p class="px-3 mb-3 text-xs font-bold uppercase tracking-wider text-slate-400">Settings</p>
                            <a @click="sidebarOpen = false" href="{{ route('admin.settings') }}" class="nav-link block rounded-xl px-3 py-2.5 text-white/80 {{ request()->routeIs('admin.settings') ? 'active' : '' }}"><i class="fas fa-cog mr-2 text-yellow-400"></i> Settings</a>
                        </div>
                    </nav>

                    <footer class="border-t border-white/10 p-4 space-y-2">
                        <a href="{{ route('dashboard') }}" class="nav-link block rounded-xl px-3 py-2.5 text-white/80"><i class="fas fa-globe mr-2 text-cyan-400"></i> View Site</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link w-full rounded-xl px-3 py-2.5 text-left text-white/80 hover:bg-red-500/20"><i class="fas fa-sign-out-alt mr-2 text-red-400"></i> Logout</button>
                        </form>
                        <div class="pt-2 text-center text-xs text-slate-500">Prof Coy 2026</div>
                    </footer>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="min-w-0 flex-1">
                <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur">
                    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                        <div class="flex items-center gap-3">
                            <button type="button" @click="sidebarOpen = true" class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 hover:bg-slate-100 lg:hidden" aria-label="Open admin navigation">
                                <i class="fas fa-bars text-lg"></i>
                            </button>
                            <div>
                                <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">@yield('title', 'Dashboard')</h1>
                                <p class="mt-1 text-sm text-slate-500">Manage your platform resources</p>
                            </div>
                        </div>
                        <div class="hidden text-right text-sm text-slate-600 sm:block">
                            <p class="font-semibold">{{ now()->format('l, F j, Y') }}</p>
                            <p>{{ now()->format('H:i') }}</p>
                        </div>
                    </div>
                </header>

                <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8">
                    @if(session('success'))
                        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 shadow-sm">
                            <i class="fas fa-check-circle text-lg"></i>
                            <div>
                                <p class="font-semibold">Success!</p>
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 shadow-sm">
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
    </div>
</body>
</html>
