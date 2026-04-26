@extends('layouts.app')

@section('title', $lecturer->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Back Button -->
    <a href="{{ route('lecturers.index') }}" class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-medium">
        <i class="fas fa-arrow-left"></i> Back to Lecturers
    </a>

    <!-- Lecturer Profile Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-green-500 to-green-600 h-3"></div>
        <div class="p-8">
            <div class="flex items-start gap-6 mb-6">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-4xl font-bold shadow-lg flex-shrink-0">
                    {{ substr($lecturer->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $lecturer->name }}</h1>
                    <p class="text-gray-600 mt-1">{{ $lecturer->title ?? 'Lecturer' }} • {{ $lecturer->department }}</p>
                    
                    <!-- Rating -->
                    <div class="flex items-center gap-2 mt-2">
                        <div class="flex items-center">
                            @for($i=1;$i<=5;$i++)
                                <i class="fas fa-star {{ $i <= round($lecturer->average_rating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                            @endfor
                        </div>
                        <span class="font-semibold text-gray-900">{{ number_format($lecturer->average_rating ?? 0, 1) }} / 5</span>
                        <span class="text-gray-500 text-sm">({{ $lecturer->reviews_count ?? 0 }} reviews)</span>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pb-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <i class="fas fa-envelope text-blue-600 text-xl"></i>
                    <div>
                        <p class="text-xs text-gray-600">Email</p>
                        <p class="font-medium">{{ $lecturer->email ?? 'Not available' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-phone text-green-600 text-xl"></i>
                    <div>
                        <p class="text-xs text-gray-600">Phone</p>
                        <p class="font-medium">{{ $lecturer->phone ?? 'Not available' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-map-marker-alt text-red-600 text-xl"></i>
                    <div>
                        <p class="text-xs text-gray-600">Office</p>
                        <p class="font-medium">{{ $lecturer->office_location ?? 'Not specified' }}</p>
                    </div>
                </div>
            </div>

            <!-- Bio -->
            @if($lecturer->bio)
                <div class="pt-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-3">About</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $lecturer->bio }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Courses Taught -->
    @if($courses->count())
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-8 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-book mr-2"></i>
                    Courses Taught ({{ $courses->count() }})
                </h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($courses as $course)
                    <div class="p-4 border border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition">
                        <p class="font-bold text-gray-900">{{ $course->course_code }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $course->course_title }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Review Form -->
    @auth
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-8 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-star mr-2"></i>
                    Rate this Lecturer
                </h2>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('lecturers.review', $lecturer) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Your Rating <span class="text-red-500">*</span></label>
                        <div class="flex gap-3">
                            @for($i=1;$i<=5;$i++)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $i }}" required class="w-4 h-4" {{ $userReview && $userReview->rating == $i ? 'checked' : '' }}>
                                    <span class="text-2xl">
                                        @for($j=1;$j<=5;$j++)
                                            <i class="fas fa-star {{ $j <= $i ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </span>
                                </label>
                            @endfor
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Course Code (optional)</label>
                        <input type="text" name="course_code" placeholder="E.g., CS 101" value="{{ $userReview->course_code ?? '' }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Your Comment (optional)</label>
                        <textarea name="comment" rows="3" placeholder="Share your experience with this lecturer..." 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">{{ $userReview->comment ?? '' }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-bold transition">
                        <i class="fas fa-paper-plane mr-2"></i> Submit Review
                    </button>
                </form>
            </div>
        </div>
    @endauth

    <!-- Reviews List -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-8 py-4">
            <h2 class="text-lg font-bold text-white flex items-center">
                <i class="fas fa-comments mr-2"></i>
                Student Reviews ({{ $reviews->total() }})
            </h2>
        </div>
        <div class="p-6 space-y-4">
            @forelse($reviews as $review)
                <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <p class="font-bold text-gray-900">{{ $review->user->name }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="flex">
                                    @for($i=1;$i<=5;$i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @if($review->course_code)
                        <p class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded inline-block mb-2">{{ $review->course_code }}</p>
                    @endif
                    @if($review->comment)
                        <p class="text-gray-700 text-sm">{{ $review->comment }}</p>
                    @endif
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-comment-slash text-3xl mb-2 block opacity-30"></i>
                    <p>No reviews yet. Be the first to review!</p>
                </div>
            @endforelse
        </div>
        @if($reviews->hasPages())
            <div class="p-6 border-t">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>
@endsection