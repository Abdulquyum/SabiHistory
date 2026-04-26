<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 dark:text-white">Dashboard</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Welcome back! Here's your learning summary.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- My Materials Card -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">My Materials</p>
                            <p class="text-4xl font-bold mt-2">{{ $userUploads }}</p>
                        </div>
                        <i class="fas fa-files text-4xl opacity-20"></i>
                    </div>
                </div>

                <!-- My Reviews Card -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Lecturer Reviews</p>
                            <p class="text-4xl font-bold mt-2">{{ $userReviews }}</p>
                        </div>
                        <i class="fas fa-star text-4xl opacity-20"></i>
                    </div>
                </div>

                <!-- Bookmarked Materials Card -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Study Points</p>
                            <p class="text-4xl font-bold mt-2">{{ $userPoints }}</p>
                        </div>
                        <i class="fas fa-bookmark text-4xl opacity-20"></i>
                    </div>
                </div>

                <!-- AI Sessions Card -->
                <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-pink-100 text-sm font-medium">AI Sessions</p>
                            <p class="text-4xl font-bold mt-2">{{ $userAiSessions }}</p>
                        </div>
                        <i class="fas fa-robot text-4xl opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Welcome Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl mb-8">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-8 text-white">
                    <h3 class="text-2xl font-bold">Welcome to SabiHistory!</h3>
                    <p class="text-indigo-100 mt-2">Your platform for studying better. Access course materials, explore lecturers, and enhance your learning.</p>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('materials.index') }}" class="p-4 border-2 border-blue-200 rounded-lg hover:bg-blue-50 transition group">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-file-pdf text-2xl text-blue-600 group-hover:scale-110 transition"></i>
                                <div>
                                    <p class="font-semibold text-gray-900">Browse Materials</p>
                                    <p class="text-sm text-gray-600">Find study resources</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('lecturers.index') }}" class="p-4 border-2 border-green-200 rounded-lg hover:bg-green-50 transition group">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-chalkboard-user text-2xl text-green-600 group-hover:scale-110 transition"></i>
                                <div>
                                    <p class="font-semibold text-gray-900">View Lecturers</p>
                                    <p class="text-sm text-gray-600">Rate & review</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('past-questions.index') }}" class="p-4 border-2 border-purple-200 rounded-lg hover:bg-purple-50 transition group">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-question-circle text-2xl text-purple-600 group-hover:scale-110 transition"></i>
                                <div>
                                    <p class="font-semibold text-gray-900">Past Questions</p>
                                    <p class="text-sm text-gray-600">Practice & prepare</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Project Submission -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition mb-8">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Final Year Project Submission
                    </h3>
                </div>
                <div class="p-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">Upload your project report</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Submit a PDF or Word document and wait for admin approval before it appears in the archive.</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-700">
                            <i class="fas fa-upload"></i> Upload Project
                        </a>
                        <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-semibold text-emerald-700 hover:bg-emerald-100">
                            <i class="fas fa-folder-open"></i> View Archive
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Featured Section -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="bg-gradient-to-r from-orange-500 to-red-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-fire mr-2"></i>
                            Recommended Materials
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @forelse($recommendedMaterials as $material)
                            <a href="{{ route('materials.show', $material) }}" class="block rounded-lg border border-gray-200 p-4 hover:border-orange-400 hover:bg-orange-50 transition">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $material->title }}</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ $material->course->course_code ?? 'Course' }} · Level {{ $material->level }}
                                        </p>
                                    </div>
                                    <span class="rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700">
                                        {{ $material->downloads }} downloads
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3 opacity-30"></i>
                                <p class="mt-2">No recommended materials yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Tips Section -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-xl transition">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-newspaper text-red-500 mr-2"></i> Recent News
                    </h3>
                    <div class="space-y-3">
                        @forelse($recentNews as $newsItem)
                            <a href="{{ route('news.show', $newsItem) }}" class="block rounded-lg border border-gray-200 p-4 hover:border-red-300 hover:bg-red-50 transition">
                                <p class="font-semibold text-gray-900 line-clamp-2">{{ $newsItem->title }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $newsItem->created_at->diffForHumans() }}</p>
                            </a>
                        @empty
                            <p class="text-sm text-gray-500">No recent news posts.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
