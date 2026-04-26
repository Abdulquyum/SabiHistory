@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Lecturers Management</h1>
            <p class="text-gray-600 mt-1">Manage all lecturers in the system</p>
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition flex items-center gap-2" data-bs-toggle="modal" data-bs-target="#addLecturerModal">
            <i class="fas fa-plus"></i> Add Lecturer
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Lecturers Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                        <th class="px-6 py-4 text-left text-sm font-semibold">Name</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Title</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Department</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Courses</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Reviews</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($lecturers as $lecturer)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $lecturer->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $lecturer->title ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $lecturer->email ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $lecturer->department }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-book mr-1"></i>
                                    {{ $lecturer->courses_count ?? 0 }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-star mr-1"></i>
                                    {{ $lecturer->reviews_count ?? 0 }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <form method="POST" action="{{ route('admin.lecturers.delete', $lecturer) }}" class="inline" onsubmit="return confirm('Delete this lecturer?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-medium transition">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3 opacity-50"></i>
                                <p class="mt-2">No lecturers found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $lecturers->links() }}
    </div>
</div>

<!-- Add Lecturer Modal -->
<div class="modal fade" id="addLecturerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-to-r from-orange-500 to-orange-600 text-white border-0">
                <h5 class="modal-title"><i class="fas fa-plus mr-2"></i> Add Lecturer</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.lecturers.store') }}">
                @csrf
                <div class="modal-body space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                        <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Enter lecturer name" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="e.g., Dr., Prof.">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="lecturer@example.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Department *</label>
                        <input type="text" name="department" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Enter department" required>
                    </div>
                </div>
                <div class="modal-footer bg-gray-50 border-t">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg">Add Lecturer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
