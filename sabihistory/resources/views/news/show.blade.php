@extends('layouts.app')

@section('title', $news->title)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Back Button -->
    <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 font-medium">
        <i class="fas fa-arrow-left"></i> Back to News
    </a>

    <!-- News Article Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-red-500 to-red-600 h-3"></div>
        <div class="p-8">
            <!-- Header -->
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $news->title }}</h1>
            
            <!-- Meta Info -->
            <div class="flex items-center flex-wrap gap-3 pb-6 border-b border-gray-200">
                <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full">
                    {{ ucfirst($news->category) }}
                </span>
                <span class="text-gray-600 flex items-center gap-1">
                    <i class="fas fa-calendar text-red-600"></i>
                    {{ $news->published_at->format('F j, Y') }}
                </span>
                <span class="text-gray-600 flex items-center gap-1">
                    <i class="fas fa-clock text-red-600"></i>
                    {{ $news->published_at->format('h:i A') }}
                </span>
            </div>

            <!-- Featured Image -->
            @if($news->attachment_type === 'image' && $news->attachment_path)
                <div class="my-8 rounded-lg overflow-hidden shadow-md">
                    <img src="{{ asset('storage/' . $news->attachment_path) }}" alt="{{ $news->title }}" class="w-full h-auto object-cover">
                </div>
            @elseif($news->image_url)
                <div class="my-8 rounded-lg overflow-hidden shadow-md">
                    <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="w-full h-auto object-cover">
                </div>
            @endif

            @if($news->attachment_type === 'pdf' && $news->attachment_path)
                <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-lg space-y-3">
                    <a href="{{ asset('storage/' . $news->attachment_path) }}" target="_blank" class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 font-medium">
                        <i class="fas fa-file-pdf"></i>
                        Open attached PDF
                    </a>
                    <div class="rounded-lg overflow-hidden border border-red-200 bg-white">
                        <iframe
                            src="{{ asset('storage/' . $news->attachment_path) }}#toolbar=1&navpanes=0"
                            class="w-full h-[560px]"
                            title="PDF Preview"
                        ></iframe>
                    </div>
                </div>
            @endif

            <!-- Content -->
            <div class="prose prose-lg max-w-none mb-8 text-gray-700 leading-relaxed">
                {!! nl2br(e($news->content)) !!}
            </div>

            <!-- Source Link -->
            @if($news->source_url)
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <a href="{{ $news->source_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
                        <i class="fas fa-external-link-alt"></i>
                        View Original Source
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Share Section -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="font-bold text-gray-900 mb-3">Share This News</h3>
        <div class="flex gap-2">
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($news->title) }}&url={{ route('news.show', $news) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                <i class="fab fa-twitter"></i> Twitter
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('news.show', $news) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                <i class="fab fa-facebook"></i> Facebook
            </a>
            <button onclick="copyToClipboard('{{ route('news.show', $news) }}')" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition">
                <i class="fas fa-link"></i> Copy Link
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Link copied to clipboard!');
        });
    }
</script>
@endpush
@endsection