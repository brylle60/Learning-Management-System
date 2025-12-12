<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $courses = \App\Models\Course::with('instructor')->latest()->take(6)->get();
    return view('welcome', compact('courses'));
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isInstructor()) {
        // Instructor dashboard data
        $courses = $user->courses()->with('students')->latest()->get();
        
        $totalStudents = $courses->sum(function($course) {
            return $course->students->count();
        });
        
        $completedEnrollments = $courses->sum(function($course) {
            return $course->students->where('pivot.is_completed', true)->count();
        });
        
        return view('dashboard', compact('courses', 'totalStudents', 'completedEnrollments'));
    } else {
        // Student dashboard
        $enrolledCourses = $user->enrolledCourses()->with('instructor')->get();
        return view('dashboard', compact('enrolledCourses'));
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Course routes visible to all logged‑in users
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');

    // Student enrollment routes - MUST BE HERE, NOT inside instructor middleware
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    Route::delete('/courses/{course}/unenroll', [CourseController::class, 'unenroll'])->name('courses.unenroll');
    
    // Instructor-only routes (use your InstructorMiddleware alias)
    Route::middleware('instructor')->group(function () {
        Route::get('/instructor/dashboard', [InstructorController::class, 'dashboard'])->name('instructor.dashboard');
        Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
        Route::patch('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
    });

    Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/picture', [ProfileController::class, 'updatePicture'])->name('profile.picture.update'); // ADD THIS LINE
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


    
    // This must come LAST - after /courses/create and /courses/{course}/edit
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
});

require __DIR__.'/auth.php';