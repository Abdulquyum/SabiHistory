@extends('layouts.app')

@section('title', 'Upload Project')

@section('content')
@php
    $uploadMax = ini_get('upload_max_filesize');
@endphp
<div class="max-w-3xl mx-auto space-y-6">
    <div>
        <h1 class="text-4xl font-bold text-gray-900">Upload Final Year Project</h1>
        <p class="text-gray-600 mt-2">Share a project report with the archive. Admin approval is required before it appears publicly.</p>
    </div>

    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-start gap-3">
        <i class="fas fa-info-circle text-emerald-600 text-xl mt-0.5"></i>
        <div class="text-sm">
            <p class="font-semibold text-emerald-900">Upload Requirements</p>
            <ul class="text-emerald-800 mt-1 space-y-1 text-xs">
                <li>• Accepts PDF, DOC, and DOCX files</li>
                <li>• Maximum size is {{ $uploadMax }}</li>
                <li>• Approved uploads will appear in the archive</li>
            </ul>
        </div>
    </div>

    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-lg p-8 space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-bold text-gray-900 mb-2">Project Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('title') border-red-500 @enderror" placeholder="E.g., The Role of Women in the Nigerian Civil War">
            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Author Name <span class="text-red-500">*</span></label>
                <input type="text" name="author_name" value="{{ old('author_name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('author_name') border-red-500 @enderror" placeholder="Full name">
                @error('author_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Matric Number</label>
                <input type="text" name="matric_no" value="{{ old('matric_no') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Optional">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Department <span class="text-red-500">*</span></label>
                <input type="text" name="department" value="{{ old('department') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('department') border-red-500 @enderror" placeholder="Department name">
                @error('department')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Level</label>
                <select name="level" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Select level</option>
                    @foreach([100,200,300,400] as $level)
                        <option value="{{ $level }}" {{ old('level') == $level ? 'selected' : '' }}>Level {{ $level }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Year Completed <span class="text-red-500">*</span></label>
                <input type="number" name="year_completed" value="{{ old('year_completed', now()->year) }}" min="1900" max="{{ now()->year }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('year_completed') border-red-500 @enderror">
                @error('year_completed')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-900 mb-2">Abstract / Description</label>
            <textarea name="abstract" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Brief summary of the project">{{ old('abstract') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-900 mb-2">Project File <span class="text-red-500">*</span></label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-emerald-500 transition cursor-pointer" onclick="document.getElementById('fileInput').click()">
                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2 block"></i>
                <p class="text-gray-600 font-medium">Click to upload your project file</p>
                <p class="text-gray-500 text-sm">PDF, DOC, or DOCX up to {{ $uploadMax }}</p>
                <input type="file" id="fileInput" name="file" accept=".pdf,.doc,.docx" class="hidden" required onchange="updateFileName(this)">
                <p id="fileName" class="text-emerald-600 text-sm mt-2"></p>
            </div>
            @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg font-bold transition flex items-center justify-center gap-2">
                <i class="fas fa-upload"></i> Upload Project
            </button>
            <a href="{{ route('projects.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 px-6 py-2 rounded-lg font-bold transition text-center">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    function updateFileName(input) {
        const fileName = document.getElementById('fileName');
        if (input.files && input.files[0]) {
            fileName.textContent = '✓ ' + input.files[0].name;
        }
    }
</script>
@endsection