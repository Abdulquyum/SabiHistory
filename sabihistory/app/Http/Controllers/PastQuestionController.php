<?php

namespace App\Http\Controllers;

use App\Models\PastQuestion;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PastQuestionController extends Controller
{
    public function index(Request $request)
    {
        $query = PastQuestion::with('course');

        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->has('year')) {
            $query->where('year', $request->year);
        }

        $pastQuestions = $query->latest()->paginate(20);
        $courses = Course::all();
        $availableYears = PastQuestion::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('past-questions.index', compact('pastQuestions', 'courses', 'availableYears'));
    }

    public function download(PastQuestion $pastQuestion)
    {
        $pastQuestion->incrementDownloads();
        
        if (!Storage::disk('public')->exists($pastQuestion->question_pdf_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($pastQuestion->question_pdf_path, "past_question_{$pastQuestion->course->course_code}_{$pastQuestion->year}.pdf");
    }

    public function downloadSolution(PastQuestion $pastQuestion)
    {
        if (!$pastQuestion->solution_pdf_path) {
            abort(404, 'Solution not available.');
        }

        return Storage::disk('public')->download($pastQuestion->solution_pdf_path, "solution_{$pastQuestion->course->course_code}_{$pastQuestion->year}.pdf");
    }

    // Admin only: upload new past question
    public function create()
    {
        $this->authorize('admin');
        $courses = Course::all();
        return view('past-questions.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $this->authorize('admin');

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'year' => 'required|integer|min=1990|max=' . date('Y'),
            'exam_type' => 'required|string',
            'question_pdf' => 'required|file|mimes:pdf|max:10240',
            'solution_pdf' => 'nullable|file|mimes:pdf|max:10240'
        ]);

        $questionPath = $request->file('question_pdf')->store('past-questions', 'public');
        $solutionPath = $request->file('solution_pdf') ? $request->file('solution_pdf')->store('past-questions/solutions', 'public') : null;

        PastQuestion::create([
            'course_id' => $request->course_id,
            'year' => $request->year,
            'exam_type' => $request->exam_type,
            'question_pdf_path' => $questionPath,
            'solution_pdf_path' => $solutionPath,
            'uploaded_by' => Auth::id()
        ]);

        return redirect()->route('past-questions.index')->with('success', 'Past question uploaded successfully.');
    }
}