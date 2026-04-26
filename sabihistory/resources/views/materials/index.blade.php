@extends('layouts.app')

@section('title', 'Materials')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">Study Materials</h1>
            <p class="text-gray-600 mt-1">Browse and share course resources</p>
        </div>
        @auth
            <a href="{{ route('materials.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition flex items-center gap-2 shadow-lg">
                <i class="fas fa-cloud-upload-alt"></i> Upload Material
            </a>
        @endauth
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <input type="text" name="search" placeholder="Search materials..." value="{{ request('search') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="course_id" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Courses</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                        {{ $course->course_code }} - {{ $course->course_title }}
                    </option>
                @endforeach
            </select>
            <select name="level" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Levels</option>
                @foreach([100,200,300,400] as $level)
                    <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>Level {{ $level }}</option>
                @endforeach
            </select>
            <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Types</option>
                <option value="pdf" {{ request('type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                <option value="docx" {{ request('type') == 'docx' ? 'selected' : '' }}>Word</option>
                <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Image</option>
                <option value="link" {{ request('type') == 'link' ? 'selected' : '' }}>Link</option>
            </select>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">Filter</button>
        </form>
    </div>

    <!-- Materials Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($materials as $material)
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition overflow-hidden">
                <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-2"></div>
                <div class="p-6">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <a href="{{ route('materials.show', $material) }}" class="font-bold text-lg text-gray-900 hover:text-blue-600 transition">
                                {{ Str::limit($material->title, 50) }}
                            </a>
                            <p class="text-sm text-gray-600 mt-1">{{ $material->course->course_code }} • Level {{ $material->level }}</p>
                        </div>
                        <div class="text-2xl">
                            @if($material->type == 'pdf')
                                <i class="fas fa-file-pdf text-red-500"></i>
                            @elseif($material->type == 'link')
                                <i class="fas fa-link text-blue-500"></i>
                            @else
                                <i class="fas fa-file text-gray-500"></i>
                            @endif
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ Str::limit($material->description, 80) }}</p>
                    <div class="flex justify-between items-center text-xs text-gray-600 border-t pt-3">
                        <span class="flex items-center gap-1"><i class="fas fa-download text-blue-500"></i> {{ $material->downloads }}</span>
                        <span class="flex items-center gap-1"><i class="fas fa-eye text-green-500"></i> {{ $material->views }}</span>
                        <span class="flex items-center gap-1"><i class="fas fa-thumbs-up text-yellow-500"></i> {{ $material->upvotes }}</span>
                    </div>
                    <div class="text-xs text-gray-500 mt-2">by <span class="font-semibold">{{ $material->uploader->name }}</span></div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 text-gray-500">
                <i class="fas fa-folder-open text-6xl mb-4 opacity-30"></i>
                <p class="text-lg">No materials found. Be the first to upload!</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $materials->withQueryString()->links() }}
    </div>
</div>
@endsection