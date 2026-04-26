@extends('layouts.app')

@section('title', 'News')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-4xl font-bold text-gray-900">Department News</h1>
        <p class="text-gray-600 mt-2">Stay updated with latest news and announcements</p>
    </div>

    <!-- News List -->
    <div class="space-y-4">
        @forelse($news as $item)
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition overflow-hidden">
                <div class="bg-gradient-to-r from-red-400 to-red-600 h-2"></div>
                <div class="p-6">
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <div class="flex-1">
                            <a href="{{ route('news.show', $item) }}" class="text-xl font-bold text-gray-900 hover:text-red-600 transition line-clamp-2">
                                {{ $item->title }}
                            </a>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                                    {{ ucfirst($item->category) }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $item->published_at->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                        @if($item->image_url)
                            <div class="w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden">
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                    </div>
                    <p class="text-gray-600 text-sm line-clamp-2 mb-3">{{ Str::limit($item->content, 150) }}</p>
                    <a href="{{ route('news.show', $item) }}" class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 font-medium text-sm">
                        Read More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <i class="fas fa-newspaper text-6xl text-gray-300 mb-4 block"></i>
                <p class="text-gray-600 text-lg font-medium">No news yet</p>
                <p class="text-gray-500 text-sm mt-1">Check back soon for updates</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $news->links() }}
    </div>
</div>
@endsection