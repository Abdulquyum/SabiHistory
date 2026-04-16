<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('lecturer')->paginate(20);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $this->authorize('admin');
        $lecturers = Lecturer::all();
        return view('courses.create', compact('lecturers'));
    }

    public function store(Request $request)
    {
        $this->authorize('admin');

        $request->validate([
            'course_code' => 'required|string|unique:courses',
            'course_title' => 'required|string',
            'level' => 'required|in:100,200,300,400',
            'semester' => 'required|in:first,second',
            'credits' => 'required|integer|min:1|max:6',
            'lecturer_id' => 'nullable|exists:lecturers,id'
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')->with('success', 'Course added.');
    }
}