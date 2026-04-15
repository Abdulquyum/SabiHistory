<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\PastQuestionController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Materials routes
Route::resource('materials', MaterialController::class);
Route::post('/materials/{material}/upvote', [MaterialController::class, 'upvote'])
    ->middleware('auth')
    ->name('materials.upvote');
Route::get('/materials/{material}/download', [MaterialController::class, 'download'])
    ->name('materials.download');

// Past Questions routes
Route::get('/past-questions', [PastQuestionController::class, 'index'])
    ->name('past-questions.index');
Route::get('/past-questions/{pastQuestion}/download', [PastQuestionController::class, 'download'])
    ->name('past-questions.download');
Route::get('/past-questions/{pastQuestion}/solution', [PastQuestionController::class, 'downloadSolution'])
    ->name('past-questions.solution');

// Lecturers routes
Route::get('/lecturers', [LecturerController::class, 'index'])->name('lecturers.index');
Route::get('/lecturers/{lecturer}', [LecturerController::class, 'show'])->name('lecturers.show');
Route::post('/lecturers/{lecturer}/review', [LecturerController::class, 'storeReview'])
    ->middleware('auth')
    ->name('lecturers.review');

// AI routes
Route::post('/ai/research', [AIController::class, 'research'])->name('ai.research');
Route::post('/ai/summarize', [AIController::class, 'summarize'])
    ->middleware('auth')
    ->name('ai.summarize');
Route::post('/ai/find-related', [AIController::class, 'findRelated'])->name('ai.find-related');
Route::post('/ai/check-plagiarism', [AIController::class, 'checkPlagiarism'])
    ->middleware('auth')
    ->name('ai.check-plagiarism');

// News routes
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

// Quick links page
Route::get('/links', function () {
    return view('links');
})->name('links');

// Final year projects (read-only)
Route::get('/projects', function () {
    return view('projects.index');
})->name('projects.index');

Route::get('/projects/{id}', function ($id) {
    return view('projects.show', compact('id'));
})->name('projects.show');

// About page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/materials/pending', [MaterialController::class, 'pending'])->name('admin.materials.pending');
    Route::post('/materials/{material}/approve', [MaterialController::class, 'approve'])->name('admin.materials.approve');
    Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('admin.materials.destroy');
    Route::post('/news', [NewsController::class, 'store'])->name('admin.news.store');
    Route::post('/courses', [CourseController::class, 'store'])->name('admin.courses.store');
});

require __DIR__.'/auth.php';