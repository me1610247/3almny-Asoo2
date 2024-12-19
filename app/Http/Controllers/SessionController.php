<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Session;
use App\Models\SessionApplication;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function create(){
        return view('trainers.session');
    }
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'number_of_sessions' => 'required|min:1',
        ]);
    
        // Check if the logged-in user is a trainer
        $trainer = Auth::user()->trainer;  // Assuming a user has a one-to-one trainer relation
    
        if (!$trainer) {
            return redirect()->route('home')->with('error', 'You are not a registered trainer.');
        }
    
        // Retrieve the course
        $course = Course::find($request->course_id);
    
        // Create a new session
        $session = new Session([
            'trainer_id' => $trainer->id,  // Use the trainer's ID, not the user ID
            'course_id' => $course->id,
            'price' => $course->price,
            'number_of_sessions' => $request->number_of_sessions,
            'status' => 'pending',  // Default status is pending
        ]);
        
        // Save the session
        $session->save();
    
        // Redirect back with success message
        return redirect()->route('home.trainers')->with('success', 'Your Session has been submitted and is awaiting admin approval.');
    }
    
public function approve(Session $session)
{
    $session->status = 'accepted';
    $session->trainer_id = $session->trainer_id ?? $session->trainer->id;
    $session->save();

    return redirect()->route('admin.pending-sessions')->with('success', 'Session approved.');
}

public function reject(Session $session)
{
    $session->status = 'rejected';
    $session->trainer_id = $session->trainer_id ?? $session->trainer->id;
    $session->save();

    return redirect()->route('admin.pending-sessions')->with('success', 'Session rejected.');
}
public function showSessions()
{
    $trainerId = Auth::user()->trainer->id; // Get the trainer's ID

    // Ensure the query fetches sessions for the logged-in trainer and status is either 'accepted' or 'pending'
    $sessions = Session::where('trainer_id', $trainerId)
                        ->whereIn('status', ['accepted', 'pending'])
                        ->get();

    return view('trainers.sessions', compact('sessions'));
}

public function showAvailableSessions(Request $request)
{
    $userId = auth()->id();
    
    // Get the gender filter from the request
    $genderFilter = $request->get('gender');
    
    // Retrieve sessions with the trainer's gender filter and eager load reviews
    $sessions = Session::with('course.trainer.user') // Eager load trainer and user details
        ->when($genderFilter, function ($query) use ($genderFilter) {
            return $query->whereHas('trainer', function ($query) use ($genderFilter) {
                $query->where('gender', $genderFilter);
            });
        })
        ->get();

    // Get the list of session IDs that the user has applied to
    $appliedSessions = SessionApplication::where('user_id', $userId)
                                          ->whereIn('session_id', $sessions->pluck('id'))
                                          ->pluck('session_id')
                                          ->toArray();

    // Check if the user has reviewed the session already
    foreach ($sessions as $session) {
        $session->has_reviewed = $session->trainer->hasUserReviewed($userId);
    }

    return view('trainee.sessions', compact('sessions', 'appliedSessions'));
}


public function endSession(Session $session)
{
    // Check if the logged-in user is the trainer for this session
    if ($session->trainer_id !== auth()->id()) {
        return redirect()->back()->with('error', 'You are not authorized to end this session.');
    }

    // Mark the session as completed
    $session->status = 'completed';
    $session->save();

    return redirect()->route('session.show')->with('success', 'Session has been completed.');
}



public function applyForSession(Request $request, $sessionId)
{
    $application = SessionApplication::create([
        'user_id' => auth()->id(),
        'session_id' => $sessionId,
        'status' => 'pending'
    ]);

    return redirect()->back()->with('success', 'Application submitted and is pending approval.');
}

}
