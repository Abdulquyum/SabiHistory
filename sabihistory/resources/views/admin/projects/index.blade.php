@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Projects Management</h1>
            <p class="text-gray-600 mt-1">Review, approve, and publish final year project submissions</p>
        </div>

        <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-700">
            <i class="fas fa-upload"></i> Upload Project
        </a>
    </div>

    @if(session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white">
                        <th class="px-6 py-4 text-left text-sm font-semibold">Title</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Author</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Department</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Year</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Uploaded By</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($projects as $project)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                <a href="{{ route('projects.show', $project) }}" class="hover:text-emerald-600">{{ $project->title }}</a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $project->author_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $project->department }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $project->year_completed }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($project->is_approved)
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">Approved</span>
                                @else
                                    <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $project->uploader->name }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex flex-wrap gap-2">
                                    @if(! $project->is_approved)
                                        <form action="{{ route('admin.projects.approve', $project) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="rounded-lg bg-green-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-green-700">Approve</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.projects.reject', $project) }}" method="POST" onsubmit="return confirm('Delete this project submission?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-700">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">No project submissions yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $projects->links() }}
    </div>
</div>
@endsection