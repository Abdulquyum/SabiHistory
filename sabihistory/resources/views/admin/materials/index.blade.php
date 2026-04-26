@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Materials Management</h1>
        <p class="text-gray-600 mt-1">Review and approve materials uploaded by users</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Materials Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-green-500 to-green-600 text-white">
                        <th class="px-6 py-4 text-left text-sm font-semibold">Title</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Course</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Uploader</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Downloads</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Uploaded</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($materials as $material)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $material->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $material->course->course_code ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $material->uploader->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($material->is_approved)
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i> Approved
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">{{ $material->downloads ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $material->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if(!$material->is_approved)
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('admin.materials.approve', $material) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs font-medium transition">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.materials.reject', $material) }}" class="inline" onsubmit="return confirm('Reject this material?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-medium transition">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-500 text-xs">Already Approved</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3 opacity-50"></i>
                                <p class="mt-2">No materials found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $materials->links() }}
    </div>
</div>
@endsection
