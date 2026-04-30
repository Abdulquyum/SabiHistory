<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\PastQuestionController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProjectController;
// use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


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
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/create', [ProjectController::class, 'create'])
    ->middleware('auth')
    ->name('projects.create');
Route::post('/projects', [ProjectController::class, 'store'])
    ->middleware('auth')
    ->name('projects.store');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/projects/{project}/download', [ProjectController::class, 'download'])->name('projects.download');

// About page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/materials/pending', [MaterialController::class, 'pending'])->name('admin.materials.pending');
    Route::post('/materials/{material}/approve', [MaterialController::class, 'approve'])->name('admin.materials.approve');
    Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('admin.materials.destroy');
    Route::post('/courses', [CourseController::class, 'store'])->name('admin.courses.store');
});

// Admin Routes (protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::get('/users', [App\Http\Controllers\Admin\AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/make-admin', [App\Http\Controllers\Admin\AdminController::class, 'makeAdmin'])->name('users.make-admin');
    Route::post('/users/{user}/remove-admin', [App\Http\Controllers\Admin\AdminController::class, 'removeAdmin'])->name('users.remove-admin');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/users/create-admin', [App\Http\Controllers\Admin\AdminController::class, 'createAdminForm'])->name('users.create-admin');
    Route::post('/users/create-admin', [App\Http\Controllers\Admin\AdminController::class, 'createAdmin'])->name('users.store-admin');

    // Material Management
    Route::get('/materials', [App\Http\Controllers\Admin\AdminController::class, 'materials'])->name('materials');
    Route::post('/materials/{material}/approve', [App\Http\Controllers\Admin\AdminController::class, 'approveMaterial'])->name('materials.approve');
    Route::delete('/materials/{material}', [App\Http\Controllers\Admin\AdminController::class, 'rejectMaterial'])->name('materials.reject');

    // News Management
    Route::get('/news', [App\Http\Controllers\Admin\AdminController::class, 'news'])->name('news');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.delete');

    // Course Management
    Route::get('/courses', [App\Http\Controllers\Admin\AdminController::class, 'courses'])->name('courses');
    Route::get('/courses/{course}/edit', [App\Http\Controllers\Admin\AdminController::class, 'editCourse'])->name('courses.edit');
    Route::post('/courses', [App\Http\Controllers\Admin\AdminController::class, 'storeCourse'])->name('courses.store');
    Route::put('/courses/{course}', [App\Http\Controllers\Admin\AdminController::class, 'updateCourse'])->name('courses.update');
    Route::delete('/courses/{course}', [App\Http\Controllers\Admin\AdminController::class, 'deleteCourse'])->name('courses.delete');

    // Lecturer Management
    Route::get('/lecturers', [App\Http\Controllers\Admin\AdminController::class, 'lecturers'])->name('lecturers');
    Route::post('/lecturers', [App\Http\Controllers\Admin\AdminController::class, 'storeLecturer'])->name('lecturers.store');
    Route::delete('/lecturers/{lecturer}', [App\Http\Controllers\Admin\AdminController::class, 'deleteLecturer'])->name('lecturers.delete');

    // Settings
    Route::get('/settings', [App\Http\Controllers\Admin\AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [App\Http\Controllers\Admin\AdminController::class, 'updateSettings'])->name('settings.update');

    // Project Management
    Route::get('/projects', [App\Http\Controllers\Admin\AdminController::class, 'projects'])->name('projects.index');
    Route::post('/projects/{project}/approve', [App\Http\Controllers\Admin\AdminController::class, 'approveProject'])->name('projects.approve');
    Route::delete('/projects/{project}', [App\Http\Controllers\Admin\AdminController::class, 'rejectProject'])->name('projects.reject');
});

require __DIR__.'/auth.php';
