@extends('layouts.app')

@section('title', $material->title)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Back Button -->
    <a href="{{ route('materials.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
        <i class="fas fa-arrow-left"></i> Back to Materials
    </a>

    <!-- Material Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3"></div>
        <div class="p-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">{{ $material->title }}</h1>
                    <p class="text-gray-600 mt-2"><i class="fas fa-book mr-2 text-blue-600"></i> {{ $material->course->course_code }} • Level {{ $material->level }}</p>
                </div>
                <div class="flex gap-2">
                    <button onclick="upvote({{ $material->id }})" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 px-4 py-2 rounded-lg font-medium transition flex items-center gap-2">
                        <i class="fas fa-thumbs-up"></i> <span id="upvoteCount">{{ $material->upvotes }}</span>
                    </button>
                    <a href="{{ route('materials.download', $material) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center gap-2">
                        <i class="fas fa-download"></i> Download
                    </a>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-4 mb-6 pb-6 border-b">
                <div class="text-center">
                    <p class="text-3xl font-bold text-blue-600">{{ $material->downloads }}</p>
                    <p class="text-gray-600 text-sm">Downloads</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-green-600">{{ $material->views }}</p>
                    <p class="text-gray-600 text-sm">Views</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-yellow-600">{{ $material->upvotes }}</p>
                    <p class="text-gray-600 text-sm">Upvotes</p>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-3">Description</h2>
                <p class="text-gray-700 leading-relaxed">{{ $material->description ?? 'No description provided.' }}</p>
            </div>

            <!-- Uploader Info -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <p class="text-sm text-gray-600">
                    <i class="fas fa-user-circle mr-2 text-blue-600"></i>
                    Uploaded by <span class="font-semibold">{{ $material->uploader->name }}</span>
                    <span class="text-gray-500">{{ $material->created_at->diffForHumans() }}</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Related Materials -->
    @if($related->count())
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-8 py-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-link mr-2"></i>
                    Related Materials
                </h3>
            </div>
            <div class="p-6 space-y-3">
                @foreach($related as $rel)
                    <a href="{{ route('materials.show', $rel) }}" class="block p-3 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
                        <p class="text-blue-600 font-semibold hover:underline">{{ Str::limit($rel->title, 60) }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $rel->course->course_code }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    async function upvote(id) {
        const res = await fetch(`/materials/${id}/upvote`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
        const data = await res.json();
        if (data.success) document.getElementById('upvoteCount').innerText = data.upvotes;
    }
</script>
@endpush
@endsection