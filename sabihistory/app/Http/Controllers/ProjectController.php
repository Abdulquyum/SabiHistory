<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store']);
    }

    public function index(Request $request)
    {
        $projects = Project::approved()
            ->with('uploader')
            ->when($request->filled('search'), function ($query) use ($request) {
                $searchTerm = $request->string('search')->toString();

                $query->where(function ($builder) use ($searchTerm) {
                    $builder->where('title', 'like', "%{$searchTerm}%")
                        ->orWhere('author_name', 'like', "%{$searchTerm}%")
                        ->orWhere('department', 'like', "%{$searchTerm}%");
                });
            })
            ->latest()
            ->paginate(12);

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $maxKilobytes = $this->maxUploadKilobytes();

        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'matric_no' => 'nullable|string|max:50',
            'department' => 'required|string|max:255',
            'level' => 'nullable|in:100,200,300,400',
            'year_completed' => 'required|integer|min:1900|max:' . now()->year,
            'abstract' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx|max:' . $maxKilobytes,
        ]);

        $filePath = $request->file('file')->store('projects', 'public');

        $project = Project::create([
            'title' => $request->title,
            'author_name' => $request->author_name,
            'matric_no' => $request->matric_no,
            'department' => $request->department,
            'level' => $request->level,
            'year_completed' => $request->year_completed,
            'abstract' => $request->abstract,
            'file_path' => $filePath,
            'uploaded_by' => Auth::id(),
            'is_approved' => Auth::user()->isAdmin(),
        ]);

        Auth::user()->increment('points', 10);

        return redirect()->route('projects.show', $project)
            ->with('success', $project->is_approved ? 'Project uploaded successfully.' : 'Project uploaded and pending admin approval.');
    }

    private function maxUploadKilobytes(): int
    {
        $uploadMax = $this->iniSizeToBytes(ini_get('upload_max_filesize'));
        $postMax = $this->iniSizeToBytes(ini_get('post_max_size'));

        $bytes = min($uploadMax, $postMax);

        return max(1, (int) floor($bytes / 1024));
    }

    private function iniSizeToBytes(string $size): int
    {
        $trimmed = trim($size);

        if ($trimmed === '') {
            return 0;
        }

        $unit = strtolower(substr($trimmed, -1));
        $value = (float) $trimmed;

        return match ($unit) {
            'g' => (int) ($value * 1024 * 1024 * 1024),
            'm' => (int) ($value * 1024 * 1024),
            'k' => (int) ($value * 1024),
            default => (int) $value,
        };
    }

    public function show(Project $project)
    {
        $canViewUnapproved = Auth::check() && (Auth::user()->isAdmin() || Auth::id() === $project->uploaded_by);

        if (! $project->is_approved && ! $canViewUnapproved) {
            abort(403, 'This project is pending approval.');
        }

        $project->load('uploader');

        $relatedProjects = Project::approved()
            ->where('department', $project->department)
            ->where('id', '!=', $project->id)
            ->latest()
            ->take(4)
            ->get();

        return view('projects.show', compact('project', 'relatedProjects'));
    }

    public function download(Project $project)
    {
        $canViewUnapproved = Auth::check() && (Auth::user()->isAdmin() || Auth::id() === $project->uploaded_by);

        if (! $project->is_approved && ! $canViewUnapproved) {
            abort(403);
        }

        $project->incrementDownloads();

        if (! Storage::disk('public')->exists($project->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download(
            $project->file_path,
            $project->title . '.' . pathinfo($project->file_path, PATHINFO_EXTENSION)
        );
    }
}