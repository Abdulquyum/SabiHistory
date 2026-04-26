@extends('layouts.app')

@section('title', 'Past Questions')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-4xl font-bold text-gray-900">Past Exam Questions</h1>
        <p class="text-gray-600 mt-2">Practice with previous years' exam questions</p>
    </div>
    
    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="GET" action="{{ route('past-questions.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                <select name="course_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->course_code }} - {{ $course->course_title }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Year</label>
                <select name="year" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Years</option>
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">
                    <i class="fas fa-search mr-2"></i> Filter
                </button>
            </div>
        </form>
    </div>
    
    <!-- Past Questions List -->
    @if($pastQuestions->count())
        <div class="space-y-4">
            @foreach($pastQuestions as $pq)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-400 to-orange-600 h-2"></div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">
                                    {{ $pq->course->course_code }}
                                </h3>
                                <p class="text-gray-600 mt-1">{{ $pq->course->course_title }}</p>
                            </div>
                            <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-calendar mr-1"></i> {{ $pq->year }}
                            </span>
                        </div>

                        <!-- Download Buttons -->
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('past-questions.download', $pq) }}" 
                               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition inline-flex items-center gap-2">
                                <i class="fas fa-file-pdf"></i> Download Question
                            </a>
                            @if($pq->solution_pdf_path)
                                <a href="{{ route('past-questions.solution', $pq) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition inline-flex items-center gap-2">
                                    <i class="fas fa-check-circle"></i> Download Solution
                                </a>
                            @endif
                            <span class="text-gray-600 text-sm flex items-center gap-1 px-3 py-2">
                                <i class="fas fa-download"></i> {{ $pq->downloads ?? 0 }} downloads
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $pastQuestions->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <i class="fas fa-inbox text-6xl text-gray-300 mb-4 block"></i>
            <p class="text-gray-600 text-lg font-medium">No past questions found.</p>
            <p class="text-gray-500 text-sm mt-1">Try adjusting your filters</p>
        </div>
    @endif
</div>
@endsection