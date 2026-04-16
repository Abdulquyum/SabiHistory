<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\LecturerReview;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::withCount('reviews')
            ->orderBy('average_rating', 'desc')
            ->paginate(20);
        return view('lecturers.index', compact('lecturers'));
    }

    public function show(Lecturer $lecturer)
    {
        $courses = Course::where('lecturer_id', $lecturer->id)->get();
        $reviews = $lecturer->reviews()->with('user')->latest()->paginate(10);
        $userReview = null;
        
        if (Auth::check()) {
            $userReview = LecturerReview::where('lecturer_id', $lecturer->id)
                ->where('user_id', Auth::id())
                ->first();
        }

        return view('lecturers.show', compact('lecturer', 'courses', 'reviews', 'userReview'));
    }

    public function storeReview(Request $request, Lecturer $lecturer)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'course_code' => 'nullable|string|max:20'
        ]);

        // Check if user already reviewed
        $existing = LecturerReview::where('lecturer_id', $lecturer->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            $existing->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
                'course_code' => $request->course_code
            ]);
        } else {
            LecturerReview::create([
                'lecturer_id' => $lecturer->id,
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'comment' => $request->comment,
                'course_code' => $request->course_code
            ]);
        }

        // Update average rating
        $lecturer->updateAverageRating();

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }
}