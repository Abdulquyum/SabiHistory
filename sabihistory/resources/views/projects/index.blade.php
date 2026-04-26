@extends('layouts.app')

@section('title', 'Final Year Projects')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">Final Year Projects</h1>
            <p class="text-gray-600 mt-2">Read-only archive of approved student research projects</p>
        </div>

        @auth
            <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-700">
                <i class="fas fa-upload"></i> Upload Project
            </a>
        @endauth
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-start gap-3">
        <i class="fas fa-lock text-yellow-600 text-xl mt-0.5"></i>
        <div class="text-sm">
            <p class="font-semibold text-yellow-900">Protected Archive</p>
            <p class="text-yellow-800 mt-1">Projects are displayed for reading and download only after approval.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($projects as $project)
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 h-2"></div>
                <div class="p-6 space-y-4">
                    <div>
                        <div class="flex items-start justify-between gap-3">
                            <a href="{{ route('projects.show', $project) }}" class="font-bold text-lg text-gray-900 hover:text-emerald-600 transition">
                                {{ \Illuminate\Support\Str::limit($project->title, 60) }}
                            </a>
                            <i class="fas fa-graduation-cap text-emerald-500 text-xl"></i>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">{{ $project->author_name }} · {{ $project->department }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $project->year_completed }}</p>
                    </div>

                    <p class="text-sm text-gray-600 line-clamp-3">{{ \Illuminate\Support\Str::limit($project->abstract, 140) }}</p>

                    <div class="flex items-center justify-between border-t pt-4 text-xs text-gray-600">
                        <span class="flex items-center gap-1"><i class="fas fa-download text-emerald-500"></i> {{ $project->downloads }}</span>
                        <span class="flex items-center gap-1"><i class="fas fa-user text-slate-500"></i> {{ $project->uploader->name }}</span>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('projects.show', $project) }}" class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                            <i class="fas fa-book-open"></i> Open
                        </a>
                        <a href="{{ route('projects.download', $project) }}" class="inline-flex items-center justify-center rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-100">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-xl bg-white p-12 text-center shadow-lg">
                <i class="fas fa-folder-open text-6xl text-gray-300 mb-4 block"></i>
                <p class="text-gray-600 text-lg font-medium">No approved projects yet</p>
                <p class="text-gray-500 text-sm mt-1">Be the first to upload a project for review</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $projects->withQueryString()->links() }}
    </div>
</div>
@endsection