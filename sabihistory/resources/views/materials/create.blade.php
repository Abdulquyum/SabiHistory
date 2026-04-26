@extends('layouts.app')

@section('title', 'Upload Material')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-4xl font-bold text-gray-900">Share Study Material</h1>
        <p class="text-gray-600 mt-2">Help your classmates by uploading course materials</p>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3">
        <i class="fas fa-info-circle text-blue-600 text-xl mt-0.5"></i>
        <div class="text-sm">
            <p class="font-semibold text-blue-900">Upload Guidelines</p>
            <ul class="text-blue-800 mt-1 space-y-1 text-xs">
                <li>• Keep titles clear and descriptive</li>
                <li>• Provide brief description of the material</li>
                <li>• Respect copyright and intellectual property</li>
                <li>• Ensure material is relevant to the course</li>
            </ul>
        </div>
    </div>

    <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-lg p-8 space-y-6">
        @csrf

        <!-- Title -->
        <div>
            <label class="block text-sm font-bold text-gray-900 mb-2">Material Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" required placeholder="E.g., Linear Algebra Chapter 5 Notes" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                   value="{{ old('title') }}">
            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-bold text-gray-900 mb-2">Description</label>
            <textarea name="description" rows="4" placeholder="Briefly describe what this material covers..."
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
        </div>

        <!-- Material Type -->
        <div>
            <label class="block text-sm font-bold text-gray-900 mb-2">Material Type <span class="text-red-500">*</span></label>
            <select name="type" id="type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('type') border-red-500 @enderror">
                <option value="">Select material type...</option>
                <option value="pdf" {{ old('type') == 'pdf' ? 'selected' : '' }}>📄 PDF Document</option>
                <option value="docx" {{ old('type') == 'docx' ? 'selected' : '' }}>📝 Word Document</option>
                <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>🖼️ Image</option>
                <option value="link" {{ old('type') == 'link' ? 'selected' : '' }}>🔗 External Link</option>
                <option value="googledrive" {{ old('type') == 'googledrive' ? 'selected' : '' }}>☁️ Google Drive Link</option>
            </select>
            @error('type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- File Upload / URL Input -->
        <div id="fileUploadDiv">
            <label class="block text-sm font-bold text-gray-900 mb-2">Upload File <span class="text-red-500">*</span></label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition cursor-pointer" onclick="document.getElementById('fileInput').click()">
                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2 block"></i>
                <p class="text-gray-600 font-medium">Click to upload or drag and drop</p>
                <p class="text-gray-500 text-sm">PDF, DOCX, JPG, PNG (Max 20MB)</p>
                <input type="file" id="fileInput" name="file" accept=".pdf,.docx,.jpg,.jpeg,.png" class="hidden" onchange="updateFileName(this)">
                <p id="fileName" class="text-blue-600 text-sm mt-2"></p>
            </div>
            @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div id="urlDiv" class="hidden">
            <label class="block text-sm font-bold text-gray-900 mb-2">URL <span class="text-red-500">*</span></label>
            <input type="url" name="external_url" placeholder="https://drive.google.com/..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                   value="{{ old('external_url') }}">
            @error('external_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Course Selection -->
        <div>
            <label class="block text-sm font-bold text-gray-900 mb-2">Course <span class="text-red-500">*</span></label>
            <select name="course_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('course_id') border-red-500 @enderror">
                <option value="">Select a course...</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                        {{ $course->course_code }} - {{ $course->course_title }}
                    </option>
                @endforeach
            </select>
            @error('course_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Level Selection -->
        <div>
            <label class="block text-sm font-bold text-gray-900 mb-2">Level <span class="text-red-500">*</span></label>
            <select name="level" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('level') border-red-500 @enderror">
                <option value="">Select level...</option>
                @foreach([100,200,300,400] as $level)
                    <option value="{{ $level }}" {{ old('level') == $level ? 'selected' : '' }}>Level {{ $level }}</option>
                @endforeach
            </select>
            @error('level')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold transition flex items-center justify-center gap-2">
                <i class="fas fa-upload"></i> Share Material
            </button>
            <a href="{{ route('materials.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 px-6 py-2 rounded-lg font-bold transition text-center">
                Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const typeSelect = document.getElementById('type');
    const fileDiv = document.getElementById('fileUploadDiv');
    const urlDiv = document.getElementById('urlDiv');

    function toggleFields() {
        const type = typeSelect.value;
        if (type === 'link' || type === 'googledrive') {
            fileDiv.classList.add('hidden');
            urlDiv.classList.remove('hidden');
        } else {
            fileDiv.classList.remove('hidden');
            urlDiv.classList.add('hidden');
        }
    }
    
    function updateFileName(input) {
        const fileName = document.getElementById('fileName');
        if (input.files && input.files[0]) {
            fileName.textContent = '✓ ' + input.files[0].name;
        }
    }
    
    typeSelect.addEventListener('change', toggleFields);
    toggleFields();
</script>
@endpush
@endsection