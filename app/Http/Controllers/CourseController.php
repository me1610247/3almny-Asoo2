<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\SessionApplication;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function create()
{
    if (Auth::user()->role !== 'trainer') {
        abort(403, 'Unauthorized access.');
    }
    
    return view('trainers.course');
}
public function store(Request $request)
{
    // Validate incoming request
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'nullable|numeric',
    ]);

    // Get the authenticated user (trainer)
    $trainer = Auth::user()->trainer;

    // If trainer is authenticated
    if (!$trainer) {
        return back()->withErrors(['error' => 'Trainer profile not found.']);
    }

    // Create the course with the authenticated trainer's ID
    $course = new Course();
    $course->title = $request->title;
    $course->description = $request->description;
    $course->price = $request->price ?? 0;  // Use 0 if price is not provided
    $course->trainer_id = $trainer->id; 
    $course->approved = 0; // 0 for false or disappearing and 1 for true or appearing
    $course->save();

    return redirect()->route('home.trainers')->with('success', 'Course created successfully.');
}

public function approve(Course $course)
{
    $course->approved = true;
    $course->save();

    return redirect()->route('admin.pending-courses')->with('success', 'Course approved.');
}

public function reject(Course $course)
{
    $course->approved = false;
    $course->save();

    return redirect()->route('admin.pending-courses')->with('success', 'Course rejected.');
}
public function show($id)
{
    $course = Course::with('trainer', 'sessions.trainer.user')->findOrFail($id);
    $userId = auth()->id();
    $appliedSessions = SessionApplication::where('user_id', $userId)
                                          ->whereIn('session_id', $course->sessions->pluck('id'))
                                          ->pluck('session_id')
                                          ->toArray();

    return view('trainee.show-session-details', compact('course', 'appliedSessions'));
}

public function getApprovedCoursesForTrainer()
{
    $trainer = Auth::user()->trainer; 
    $approvedCourses = $trainer->courses()->where('approved', '1')->get();
    
    return view('trainers.courses', compact('approvedCourses'));
}
}
