@extends('layouts.admin')

@section('content')
<div class="space-y-6 max-w-3xl">
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Course</h1>
            <p class="text-gray-600 mt-1">Update course details and lecturer assignment</p>
        </div>
        <a href="{{ route('admin.courses') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-lg font-medium transition inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back to Courses
        </a>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <form method="POST" action="{{ route('admin.courses.update', $course) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Course Code *</label>
                <input type="text" name="course_code" value="{{ old('course_code', $course->course_code) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Course Title *</label>
                <input type="text" name="course_title" value="{{ old('course_title', $course->course_title) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Level *</label>
                    <select name="level" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                        <option value="">Select Level</option>
                        <option value="100" @selected(old('level', $course->level) == 100)>100</option>
                        <option value="200" @selected(old('level', $course->level) == 200)>200</option>
                        <option value="300" @selected(old('level', $course->level) == 300)>300</option>
                        <option value="400" @selected(old('level', $course->level) == 400)>400</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Semester *</label>
                    <select name="semester" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                        <option value="">Select Semester</option>
                        <option value="first" @selected(old('semester', $course->semester) === 'first')>First</option>
                        <option value="second" @selected(old('semester', $course->semester) === 'second')>Second</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Credits *</label>
                    <input type="number" name="credits" value="{{ old('credits', $course->credits) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" min="1" max="6" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lecturer</label>
                    <select name="lecturer_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <option value="">Select Lecturer</option>
                        @foreach ($lecturers as $lecturer)
                            <option value="{{ $lecturer->id }}" @selected(old('lecturer_id', $course->lecturer_id) == $lecturer->id)>{{ $lecturer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg font-medium transition">
                    Save Changes
                </button>
                <a href="{{ route('admin.courses') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-2 rounded-lg font-medium transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection