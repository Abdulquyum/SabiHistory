<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Course;
use App\Models\PastQuestion;
use App\Models\News;
use App\Models\AiSession;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Stats for dashboard
        $totalMaterials = Material::approved()->count();
        $totalCourses = Course::count();
        $totalPastQuestions = PastQuestion::count();
        $recentNews = News::latest()->take(5)->get();
        
        // User-specific data
        $userUploads = Material::where('uploaded_by', $user->id)->count();
        $userPoints = $user->points;
        
        // Recommended materials based on user's level
        $recommendedMaterials = Material::approved()
            ->where('level', $user->level)
            ->latest()
            ->take(6)
            ->get();
        
        // Popular materials
        $popularMaterials = Material::approved()
            ->orderBy('downloads', 'desc')
            ->take(5)
            ->get();
        
        // Recent AI sessions
        $recentAiSessions = AiSession::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        
        // Quick stats for charts (last 7 days uploads)
        $weeklyUploads = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = Material::whereDate('created_at', $date)->count();
            $weeklyUploads[] = [
                'date' => $date->format('D'),
                'count' => $count
            ];
        }
        
        return view('dashboard', compact(
            'totalMaterials',
            'totalCourses',
            'totalPastQuestions',
            'recentNews',
            'userUploads',
            'userPoints',
            'recommendedMaterials',
            'popularMaterials',
            'recentAiSessions',
            'weeklyUploads'
        ));
    }
}