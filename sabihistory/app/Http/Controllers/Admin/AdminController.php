<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Material;
use App\Models\Course;
use App\Models\PastQuestion;
use App\Models\Project;
use App\Models\Lecturer;
use App\Models\News;
use App\Models\AiSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    // Dashboard
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_materials' => Material::count(),
            'pending_materials' => Material::where('is_approved', false)->count(),
            'total_projects' => Project::count(),
            'pending_projects' => Project::where('is_approved', false)->count(),
            'total_courses' => Course::count(),
            'total_past_questions' => PastQuestion::count(),
            'total_lecturers' => Lecturer::count(),
            'total_ai_sessions' => AiSession::count(),
            'total_downloads' => Material::sum('downloads'),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentMaterials = Material::with('uploader')->latest()->take(5)->get();
        $pendingMaterials = Material::with('uploader')->where('is_approved', false)->latest()->take(10)->get();
        $recentProjects = Project::with('uploader')->latest()->take(5)->get();
        $pendingProjects = Project::with('uploader')->where('is_approved', false)->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentMaterials', 'pendingMaterials', 'recentProjects', 'pendingProjects'));
    }

    // User Management
    public function users()
    {
        $users = User::withCount('materials')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function makeAdmin(User $user)
    {
        $user->update(['is_admin' => true, 'role' => 'admin']);
        return back()->with('success', "{$user->name} is now an admin.");
    }

    public function removeAdmin(User $user)
    {
        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Cannot remove super admin.');
        }
        $user->update(['is_admin' => false, 'role' => 'student']);
        return back()->with('success', "Admin rights removed from {$user->name}.");
    }

    public function deleteUser(User $user)
    {
        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Cannot delete super admin.');
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    // Material Management
    public function materials()
    {
        $materials = Material::with(['course', 'uploader'])->latest()->paginate(20);
        return view('admin.materials.index', compact('materials'));
    }

    public function approveMaterial(Material $material)
    {
        $material->update(['is_approved' => true]);
        return back()->with('success', 'Material approved.');
    }

    public function rejectMaterial(Material $material)
    {
        $material->delete();
        return back()->with('success', 'Material rejected and deleted.');
    }

    // Project Management
    public function projects()
    {
        $projects = Project::with('uploader')->latest()->paginate(20);
        return view('admin.projects.index', compact('projects'));
    }

    public function approveProject(Project $project)
    {
        $project->update(['is_approved' => true]);
        return back()->with('success', 'Project approved.');
    }

    public function rejectProject(Project $project)
    {
        if ($project->file_path && Storage::disk('public')->exists($project->file_path)) {
            Storage::disk('public')->delete($project->file_path);
        }

        $project->delete();
        return back()->with('success', 'Project rejected and deleted.');
    }

    // Course Management
    public function courses()
    {
        $courses = Course::with('lecturer')->paginate(20);
        $lecturers = Lecturer::all();
        return view('admin.courses.index', compact('courses', 'lecturers'));
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'course_code' => 'required|string|unique:courses',
            'course_title' => 'required|string',
            'level' => 'required|in:100,200,300,400',
            'semester' => 'required|in:first,second',
            'credits' => 'required|integer|min:1|max:6',
            'lecturer_id' => 'nullable|exists:lecturers,id'
        ]);

        Course::create($request->all());
        return back()->with('success', 'Course added.');
    }

    public function updateCourse(Request $request, Course $course)
    {
        $request->validate([
            'course_code' => 'required|string|unique:courses,course_code,' . $course->id,
            'course_title' => 'required|string',
            'level' => 'required|in:100,200,300,400',
            'semester' => 'required|in:first,second',
            'credits' => 'required|integer|min:1|max:6',
        ]);

        $course->update($request->all());
        return back()->with('success', 'Course updated.');
    }

    public function deleteCourse(Course $course)
    {
        $course->delete();
        return back()->with('success', 'Course deleted.');
    }

    // Lecturer Management
    public function lecturers()
    {
        $lecturers = Lecturer::withCount('courses', 'reviews')->paginate(20);
        return view('admin.lecturers.index', compact('lecturers'));
    }

    public function storeLecturer(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'title' => 'nullable|string',
            'email' => 'nullable|email|unique:lecturers',
            'department' => 'required|string',
        ]);

        Lecturer::create($request->all());
        return back()->with('success', 'Lecturer added.');
    }

    public function deleteLecturer(Lecturer $lecturer)
    {
        $lecturer->delete();
        return back()->with('success', 'Lecturer deleted.');
    }

    // Settings
    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        // Store settings in database or config file
        // For now, just return success
        return back()->with('success', 'Settings updated.');
    }

    // Create Admin User (via form)
    public function createAdminForm()
    {
        return view('admin.users.create');
    }

    public function createAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => true,
            'role' => 'admin',
            'level' => 400,
        ]);

        return redirect()->route('admin.users')->with('success', 'New admin created.');
    }
}