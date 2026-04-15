<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'download']);
    }

    // List all approved materials
    public function index(Request $request)
    {
        $query = Material::approved()->with(['course', 'uploader']);

        // Filter by course
        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Filter by level
        if ($request->has('level')) {
            $query->where('level', $request->level);
        }

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Search
        if ($request->has('search')) {
            $query->search($request->search);
        }

        $materials = $query->latest()->paginate(20);
        $courses = Course::all();

        return view('materials.index', compact('materials', 'courses'));
    }

    // Show upload form
    public function create()
    {
        $courses = Course::all();
        return view('materials.create', compact('courses'));
    }

    // Store uploaded material
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:pdf,docx,image,link,googledrive',
            'course_id' => 'required|exists:courses,id',
            'level' => 'required|in:100,200,300,400',
            'file' => 'required_if:type,pdf,docx,image|file|max:20480',
            'external_url' => 'required_if:type,link,googledrive|url|nullable'
        ]);

        $materialData = [
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'course_id' => $request->course_id,
            'level' => $request->level,
            'uploaded_by' => Auth::id(),
            'is_approved' => Auth::user()->isAdmin() ? true : false // Admin auto-approve
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('materials', 'public');
            $materialData['file_path'] = $path;
            
            // Generate thumbnail for images
            if (str_starts_with($request->file('file')->getMimeType(), 'image')) {
                $materialData['thumbnail'] = $path;
            }
        }

        // Handle external URL
        if (in_array($request->type, ['link', 'googledrive'])) {
            $materialData['external_url'] = $request->external_url;
        }

        $material = Material::create($materialData);

        // Award points to uploader (5 points per upload)
        Auth::user()->increment('points', 5);

        return redirect()->route('materials.show', $material)
            ->with('success', 'Material uploaded successfully!' . ($material->is_approved ? '' : ' Awaiting admin approval.'));
    }

    // Show single material
    public function show(Material $material)
    {
        if (!$material->is_approved && !Auth::user()?->isAdmin()) {
            abort(403, 'This material is pending approval.');
        }

        $material->incrementViews();
        $related = Material::approved()
            ->where('course_id', $material->course_id)
            ->where('id', '!=', $material->id)
            ->limit(5)
            ->get();

        return view('materials.show', compact('material', 'related'));
    }

    // Download material
    public function download(Material $material)
    {
        if (!$material->is_approved && !Auth::user()?->isAdmin()) {
            abort(403);
        }

        $material->incrementDownloads();

        if ($material->type === 'link' || $material->type === 'googledrive') {
            return redirect($material->external_url);
        }

        if (!Storage::disk('public')->exists($material->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($material->file_path, $material->title . '.' . pathinfo($material->file_path, PATHINFO_EXTENSION));
    }

    // Upvote a material
    public function upvote(Material $material)
    {
        $material->increment('upvotes');
        return response()->json(['success' => true, 'upvotes' => $material->upvotes]);
    }
}