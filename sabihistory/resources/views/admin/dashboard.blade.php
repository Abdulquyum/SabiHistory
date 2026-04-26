@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="text-gray-600 mt-1">Welcome back! Here's what's happening today.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Users</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_users'] }}</p>
                </div>
                <i class="fas fa-users text-4xl opacity-20"></i>
            </div>
        </div>

        <!-- Total Materials Card -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Materials</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_materials'] }}</p>
                </div>
                <i class="fas fa-file-alt text-4xl opacity-20"></i>
            </div>
        </div>

        <!-- Pending Materials Card -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Pending Approval</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['pending_materials'] }}</p>
                </div>
                <i class="fas fa-clock text-4xl opacity-20"></i>
            </div>
        </div>

        <!-- Total Downloads Card -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Downloads</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_downloads']) }}</p>
                </div>
                <i class="fas fa-download text-4xl opacity-20"></i>
            </div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Courses -->
        <div class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Courses</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_courses'] }}</p>
                </div>
                <i class="fas fa-book text-3xl text-indigo-500 opacity-30"></i>
            </div>
        </div>

        <!-- Lecturers -->
        <div class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Lecturers</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_lecturers'] }}</p>
                </div>
                <i class="fas fa-chalkboard-user text-3xl text-orange-500 opacity-30"></i>
            </div>
        </div>

        <!-- AI Sessions -->
        <div class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">AI Sessions</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_ai_sessions'] }}</p>
                </div>
                <i class="fas fa-brain text-3xl text-pink-500 opacity-30"></i>
            </div>
        </div>
    </div>

    <!-- Project Management Callout -->
    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
            <h2 class="text-lg font-bold text-white flex items-center">
                <i class="fas fa-layer-group mr-2"></i>
                Project Management
            </h2>
        </div>
        <div class="p-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="font-semibold text-gray-900">{{ $stats['pending_projects'] }} projects awaiting review</p>
                <p class="text-sm text-gray-600 mt-1">Approve user submissions or upload approved projects directly from the archive workflow.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-700">
                    <i class="fas fa-list"></i> Review Projects
                </a>
                <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-semibold text-emerald-700 hover:bg-emerald-100">
                    <i class="fas fa-upload"></i> Upload Project
                </a>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Pending Materials -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow hover:shadow-lg transition">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4 rounded-t-xl">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    Pending Materials
                </h2>
            </div>
            <div class="p-6">
                @forelse($pendingMaterials as $material)
                    <div class="flex justify-between items-center py-3 border-b last:border-0">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $material->title }}</p>
                            <p class="text-xs text-gray-500 mt-1">by <span class="font-medium">{{ $material->uploader->name }}</span></p>
                        </div>
                        <div class="flex gap-2">
                            <form action="{{ route('admin.materials.approve', $material) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded transition text-sm">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.materials.reject', $material) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition text-sm">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No pending materials. Great job!</p>
                @endforelse
            </div>
        </div>

        <!-- Pending Projects -->
        <div class="bg-white rounded-xl shadow hover:shadow-lg transition">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4 rounded-t-xl">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Pending Projects
                </h2>
            </div>
            <div class="p-6">
                @forelse($pendingProjects as $project)
                    <div class="py-3 border-b last:border-0">
                        <p class="font-semibold text-gray-900">{{ $project->title }}</p>
                        <p class="text-xs text-gray-500 mt-1">by <span class="font-medium">{{ $project->author_name }}</span></p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No pending projects</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-xl shadow hover:shadow-lg transition">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 rounded-t-xl">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Recent Users
                </h2>
            </div>
            <div class="p-6">
                @forelse($recentUsers as $user)
                    <div class="py-3 border-b last:border-0">
                        <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No recent users</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Materials -->
    <div class="bg-white rounded-xl shadow hover:shadow-lg transition">
        <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4 rounded-t-xl">
            <h2 class="text-lg font-bold text-white flex items-center">
                <i class="fas fa-file-upload mr-2"></i>
                Recent Materials
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Uploader</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Uploaded</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentMaterials as $material)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-3 text-sm text-gray-900">{{ $material->title }}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ $material->uploader->name }}</td>
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $material->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">No recent materials</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="bg-white rounded-xl shadow hover:shadow-lg transition">
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4 rounded-t-xl">
            <h2 class="text-lg font-bold text-white flex items-center">
                <i class="fas fa-graduation-cap mr-2"></i>
                Recent Projects
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Author</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Uploaded</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentProjects as $project)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-3 text-sm text-gray-900">{{ $project->title }}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ $project->author_name }}</td>
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $project->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">No recent projects</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection