@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">News Management</h1>
            <p class="text-gray-600 mt-1">Publish department updates with an optional image or PDF attachment.</p>
        </div>
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

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-1 bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Publish News</h2>
            <form id="create-news-form" method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        <option value="">Select category</option>
                        <option value="academic" @selected(old('category') === 'academic')>Academic</option>
                        <option value="department" @selected(old('category') === 'department')>Department</option>
                        <option value="university" @selected(old('category') === 'university')>University</option>
                        <option value="general" @selected(old('category') === 'general')>General</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                    <textarea name="content" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>{{ old('content') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image URL (optional)</label>
                    <input type="url" name="image_url" value="{{ old('image_url') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="https://example.com/image.jpg">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Source URL (optional)</label>
                    <input type="url" name="source_url" value="{{ old('source_url') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="https://example.com/news-source">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Attachment (optional image or PDF)</label>
                    <input id="create-attachment" type="file" name="attachment" accept=".jpg,.jpeg,.png,.webp,.pdf,image/jpeg,image/png,image/webp,application/pdf" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-red-500">
                    <p class="text-xs text-gray-500 mt-1">Accepted: JPG, JPEG, PNG, WEBP, PDF. Max size: 5MB.</p>
                    <p id="create-attachment-error" class="text-xs text-red-600 mt-1 hidden"></p>
                </div>

                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg font-medium transition">
                    Publish Update
                </button>
            </form>
        </div>

        <div class="xl:col-span-2 bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Recent News</h2>
            </div>
            <div class="divide-y">
                @forelse($news as $item)
                    <div class="p-6 flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                        <div class="space-y-2">
                            <p class="text-sm text-gray-500">{{ optional($item->published_at)->format('M d, Y h:i A') ?? $item->created_at->format('M d, Y h:i A') }}</p>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $item->title }}</h3>
                            <div class="flex items-center gap-2 text-xs">
                                <span class="px-2 py-1 rounded-full bg-red-100 text-red-700 font-medium">{{ ucfirst($item->category) }}</span>
                                @if($item->attachment_type === 'image')
                                    <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 font-medium">Image Attachment</span>
                                @elseif($item->attachment_type === 'pdf')
                                    <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 font-medium">PDF Attachment</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($item->content, 140) }}</p>
                            <a href="{{ route('news.show', $item) }}" target="_blank" class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 text-sm font-medium">
                                <i class="fas fa-up-right-from-square"></i> View Public Page
                            </a>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.news.edit', $item) }}" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-4 py-2 rounded-lg text-sm font-medium transition inline-flex items-center gap-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.news.delete', $item) }}" onsubmit="return confirm('Delete this news post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">No news published yet.</div>
                @endforelse
            </div>

            <div class="px-6 py-4 border-t bg-gray-50">
                {{ $news->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var maxSize = 5 * 1024 * 1024;
        var allowed = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];
        var input = document.getElementById('create-attachment');
        var error = document.getElementById('create-attachment-error');
        var form = document.getElementById('create-news-form');

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
