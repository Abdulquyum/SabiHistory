@extends('layouts.admin')

@section('content')
<div class="space-y-6 max-w-4xl">
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit News</h1>
            <p class="text-gray-600 mt-1">Update the news post details, image URL, and attachment.</p>
        </div>
        <a href="{{ route('admin.news') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-lg font-medium transition inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back to News
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
            <p class="font-semibold mb-2">Please fix the following:</p>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow p-6">
        <form id="edit-news-form" method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                <input type="text" name="title" value="{{ old('title', $news->title) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
                    <option value="academic" @selected(old('category', $news->category) === 'academic')>Academic</option>
                    <option value="department" @selected(old('category', $news->category) === 'department')>Department</option>
                    <option value="university" @selected(old('category', $news->category) === 'university')>University</option>
                    <option value="general" @selected(old('category', $news->category) === 'general')>General</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                <textarea name="content" rows="8" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>{{ old('content', $news->content) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Image URL (optional)</label>
                <input type="url" name="image_url" value="{{ old('image_url', $news->image_url) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="https://example.com/image.jpg">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Source URL (optional)</label>
                <input type="url" name="source_url" value="{{ old('source_url', $news->source_url) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="https://example.com/news-source">
            </div>

            <div class="space-y-3 rounded-lg border border-gray-200 p-4 bg-gray-50">
                <p class="text-sm font-medium text-gray-800">Current Attachment</p>
                @if($news->attachment_type === 'image' && $news->attachment_path)
                    <img src="{{ asset('storage/' . $news->attachment_path) }}" alt="Current attachment" class="w-40 h-40 rounded-lg object-cover border border-gray-200">
                @elseif($news->attachment_type === 'pdf' && $news->attachment_path)
                    <a href="{{ asset('storage/' . $news->attachment_path) }}" target="_blank" class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 font-medium">
                        <i class="fas fa-file-pdf"></i> View current PDF
                    </a>
                @else
                    <p class="text-sm text-gray-500">No attachment uploaded.</p>
                @endif

                @if($news->attachment_path)
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="remove_attachment" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                        Remove current attachment
                    </label>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Replace Attachment (optional image or PDF)</label>
                <input id="edit-attachment" type="file" name="attachment" accept=".jpg,.jpeg,.png,.webp,.pdf,image/jpeg,image/png,image/webp,application/pdf" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-red-500">
                <p class="text-xs text-gray-500 mt-1">Accepted: JPG, JPEG, PNG, WEBP, PDF. Max size: 5MB.</p>
                <p id="edit-attachment-error" class="text-xs text-red-600 mt-1 hidden"></p>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition">Save Changes</button>
                <a href="{{ route('admin.news') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-2 rounded-lg font-medium transition">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        var maxSize = 5 * 1024 * 1024;
        var allowed = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];
        var input = document.getElementById('edit-attachment');
        var error = document.getElementById('edit-attachment-error');
        var form = document.getElementById('edit-news-form');

        function validateAttachment() {
            if (!input || !error) {
                return true;
            }

            error.classList.add('hidden');
            error.textContent = '';

            if (!input.files || !input.files.length) {
                return true;
            }

            var file = input.files[0];
            if (file.size > maxSize) {
                error.textContent = 'Attachment must be 5MB or less.';
                error.classList.remove('hidden');
                return false;
            }

            if (allowed.indexOf(file.type) === -1) {
                error.textContent = 'Only JPG, JPEG, PNG, WEBP, or PDF files are allowed.';
                error.classList.remove('hidden');
                return false;
            }

            return true;
        }

        if (input) {
            input.addEventListener('change', validateAttachment);
        }

        if (form) {
            form.addEventListener('submit', function (event) {
                if (!validateAttachment()) {
                    event.preventDefault();
                }
            });
        }
    })();
</script>
@endsection
