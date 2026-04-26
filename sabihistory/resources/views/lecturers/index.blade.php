@extends('layouts.app')

@section('title', 'Lecturers')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-4xl font-bold text-gray-900">Our Lecturers</h1>
        <p class="text-gray-600 mt-2">Rate and review lecturers to help your classmates</p>
    </div>

    <!-- Lecturers Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($lecturers as $lecturer)
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition overflow-hidden">
                <div class="bg-gradient-to-r from-green-400 to-green-600 h-2"></div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                            {{ substr($lecturer->name, 0, 1) }}
                        </div>
                        <div>
                            <a href="{{ route('lecturers.show', $lecturer) }}" class="font-bold text-lg text-gray-900 hover:text-green-600 transition">
                                {{ $lecturer->name }}
                            </a>
                            <p class="text-sm text-gray-600">{{ $lecturer->title ?? 'Lecturer' }}</p>
                        </div>
                    </div>

                    <!-- Department -->
                    <p class="text-sm text-gray-600 mb-3 flex items-center gap-2">
                        <i class="fas fa-building text-blue-500"></i>
                        {{ $lecturer->department }}
                    </p>

                    <!-- Rating -->
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex items-center">
                            @for($i=1;$i<=5;$i++)
                                <i class="fas fa-star {{ $i <= round($lecturer->average_rating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600">({{ $lecturer->reviews_count ?? 0 }} reviews)</span>
                    </div>

                    <!-- Courses and Email -->
                    <div class="space-y-2 mb-4 pb-4 border-b border-gray-200">
                        @if($lecturer->courses_count ?? 0 > 0)
                            <p class="text-xs text-gray-600 flex items-center gap-2">
                                <i class="fas fa-book text-purple-500"></i>
                                <span class="font-semibold">{{ $lecturer->courses_count }}</span> courses
                            </p>
                        @endif
                        @if($lecturer->email)
                            <p class="text-xs text-gray-600 flex items-center gap-2">
                                <i class="fas fa-envelope text-red-500"></i>
                                <span class="truncate">{{ $lecturer->email }}</span>
                            </p>
                        @endif
                    </div>

                    <!-- View Button -->
                    <a href="{{ route('lecturers.show', $lecturer) }}" class="w-full block text-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition">
                        <i class="fas fa-arrow-right mr-1"></i> View Profile
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 text-gray-500">
                <i class="fas fa-users text-6xl mb-4 opacity-30"></i>
                <p class="text-lg">No lecturers found</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $lecturers->links() }}
    </div>
</div>
@endsection