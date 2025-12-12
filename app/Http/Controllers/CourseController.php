<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the courses.
     */
    public function index()
    {
        $courses = Course::with('instructor')->latest()->paginate(12);
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        // Ensure only instructors can create courses
        if (!auth()->user()->isInstructor()) {
            abort(403, 'Only instructors can create courses.');
        }
        
        return view('courses.create');
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        // Ensure only instructors can create courses
        if (!auth()->user()->isInstructor()) {
            abort(403, 'Only instructors can create courses.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
        ]);

        $validated['instructor_id'] = auth()->id();

        Course::create($validated);

        return redirect()->route('courses.index')->with('success', 'Course created successfully!');
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course)
    {
        $course->load('instructor');
        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        // Make sure the instructor owns this course
        if ($course->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course)
    {
        // Make sure the instructor owns this course
        if ($course->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
        ]);

        $course->update($validated);

        return redirect()->route('courses.show', $course)->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        // Make sure the instructor owns this course
        if ($course->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $course->delete();

        return redirect()->route('instructor.dashboard')->with('success', 'Course deleted successfully!');
    }

    /**
     * Enroll student in course.
     */
    public function enroll(Course $course)
    {
        $user = Auth::user();
        
        if ($user->isInstructor()) {
            return redirect()->back()->with('error', 'Instructors cannot enroll in courses.');
        }
        
        if ($user->enrolledCourses->contains($course->id)) {
            return redirect()->back()->with('info', 'You are already enrolled in this course.');
        }
        
        $user->enrolledCourses()->attach($course->id, ['is_completed' => false]);
        
        return redirect()->back()->with('success', 'Successfully enrolled in course!');
    }

    /**
     * Unenroll student from course.
     */
    public function unenroll(Course $course)
    {
        $user = Auth::user();
        
        if (!$user->enrolledCourses->contains($course->id)) {
            return redirect()->back()->with('error', 'You are not enrolled in this course.');
        }
        
        $user->enrolledCourses()->detach($course->id);
        
        return redirect()->back()->with('success', 'Successfully unenrolled from course.');
    }
}