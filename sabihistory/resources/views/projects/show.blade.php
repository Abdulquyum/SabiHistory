@extends('layouts.app')

@section('title', $project->title)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium">
        <i class="fas fa-arrow-left"></i> Back to Projects
    </a>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-emerald-200">
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-8 py-6 text-white">
            <div class="flex flex-wrap items-center gap-3 mb-3">
                <span class="rounded-full bg-white/20 px-3 py-1 text-xs font-semibold uppercase tracking-wide">
                    {{ $project->is_approved ? 'Approved Project' : 'Pending Review' }}
                </span>
                <span class="rounded-full bg-white/20 px-3 py-1 text-xs font-semibold">{{ $project->year_completed }}</span>
            </div>
            <h1 class="text-3xl font-bold">{{ $project->title }}</h1>
            <p class="mt-2 text-emerald-100">{{ $project->author_name }} · {{ $project->department }}</p>
        </div>

        <div class="p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pb-6 border-b border-gray-200">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Author</p>
                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $project->author_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-medium">Department</p>
                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $project->department }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-medium">Year Completed</p>
                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $project->year_completed }}</p>
                </div>
            </div>

            @if($project->abstract)
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-3">Abstract</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $project->abstract }}</p>
                </div>
            @endif

            <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 flex items-start gap-3">
                <i class="fas fa-shield-alt text-emerald-600 text-lg mt-0.5"></i>
                <div class="text-sm text-emerald-900">
                    <p class="font-semibold">Read-only archive</p>
                    <p>
                        {{ $project->is_approved
                            ? 'This project is available for reading and download only. The original file remains protected in the archive.'
                            : 'This submission is visible to the uploader and admins while it waits for approval.' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('projects.download', $project) }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-700">
                    <i class="fas fa-download"></i> Download Project
                </a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <span class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-semibold text-emerald-700">
                            <i class="fas fa-user-shield"></i> Admin Access
                        </span>
                    @endif
                @endauth
            </div>

            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 text-sm text-gray-600">
                Uploaded by <span class="font-semibold text-gray-900">{{ $project->uploader->name }}</span> · {{ $project->created_at->diffForHumans() }} · {{ $project->downloads }} downloads
            </div>
        </div>
    </div>

    @if($relatedProjects->count())
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-8 py-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-link mr-2"></i>
                    Related Projects
                </h3>
            </div>
            <div class="p-6 space-y-3">
                @foreach($relatedProjects as $relatedProject)
                    <a href="{{ route('projects.show', $relatedProject) }}" class="block rounded-lg border border-gray-200 p-4 hover:border-emerald-500 hover:bg-emerald-50 transition">
                        <p class="font-semibold text-gray-900">{{ $relatedProject->title }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $relatedProject->author_name }} · {{ $relatedProject->year_completed }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection