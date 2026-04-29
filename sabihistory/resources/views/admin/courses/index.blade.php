@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Courses Management</h1>
            <p class="text-gray-600 mt-1">Manage all courses in the system</p>
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition flex items-center gap-2" data-bs-toggle="modal" data-bs-target="#addCourseModal">
            <i class="fas fa-plus"></i> Add Course
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Courses Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white">
                        <th class="px-6 py-4 text-left text-sm font-semibold">Code</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Title</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Level</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Semester</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Credits</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Lecturer</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($courses as $course)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $course->course_code }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $course->course_title }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Level {{ $course->level }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 capitalize">{{ $course->semester }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $course->credits }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $course->lecturer->name ?? 'Unassigned' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.courses.edit', $course) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs font-medium transition inline-flex items-center gap-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.courses.delete', $course) }}" class="inline" onsubmit="return confirm('Delete this course?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-medium transition">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3 opacity-50"></i>
                                <p class="mt-2">No courses found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $courses->links() }}
    </div>
</div>

<!-- Add Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-to-r from-indigo-500 to-indigo-600 text-white border-0">
                <h5 class="modal-title"><i class="fas fa-plus mr-2"></i> Add Course</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.courses.store') }}">
                @csrf
                <div class="modal-body space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Course Code *</label>
                        <input type="text" name="course_code" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="e.g., CS101" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Course Title *</label>
                        <input type="text" name="course_title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="e.g., Introduction to Programming" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Level *</label>
                        <select name="level" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            <option value="">Select Level</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="300">300</option>
                            <option value="400">400</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Semester *</label>
                        <select name="semester" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            <option value="">Select Semester</option>
                            <option value="first">First</option>
                            <option value="second">Second</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Credits *</label>
                        <input type="number" name="credits" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" min="1" max="6" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lecturer</label>
                        <select name="lecturer_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Select Lecturer</option>
                            @foreach ($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-gray-50 border-t">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg">Add Course</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
