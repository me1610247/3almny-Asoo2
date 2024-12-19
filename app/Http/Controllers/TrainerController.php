<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainer;
use App\Models\SessionApplication;
use App\Models\Session;
use App\Models\Message;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TrainerController extends Controller
{
    public function create()
    {
        return view('trainers.create');
    }
    public function store(Request $request)
    {
      $validated= $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'city' => 'required|string',
            'gender' => 'required|string',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'national_id' => 'required|string',
            'license_id' => 'required|string',
'license_end_date' => [
            'required',
            'date',
            'after_or_equal:' . Carbon::now()->addMonth()->toDateString(), // Validate that the license end date is at least 1 month from today
        ],
            'license_front_image' => 'required|image',
            'license_back_image' => 'required|image',
            'national_id_front_image' => 'required|image',
            'national_id_back_image' => 'required|image',
            'has_car' => 'required|boolean',
            'car_license_image' => 'required_if:has_car,1|image',
        ]);
        if(!$validated){
            return redirect()->back()->with('error', 'Check the error fields.');
        }
        $trainer = new Trainer();
        $trainer->user_id = auth()->id();
        $trainer->phone = $request->phone;
        $trainer->city = $request->city;
        $trainer->gender = $request->gender;
        $trainer->address = $request->address;
        $trainer->date_of_birth = $request->date_of_birth;
        $trainer->national_id = $request->national_id;
        $trainer->license_id = $request->license_id;
        $trainer->license_end_date = $request->license_end_date;
        
        // Handle file uploads
        if ($request->hasFile('license_front_image')) {
            $trainer->license_front_image = $request->file('license_front_image')->store('images');
        }
        if ($request->hasFile('license_back_image')) {
            $trainer->license_back_image = $request->file('license_back_image')->store('images');
        }
        if ($request->hasFile('national_id_front_image')) {
            $trainer->national_id_front_image = $request->file('national_id_front_image')->store('images');
        }
        if ($request->hasFile('national_id_back_image')) {
            $trainer->national_id_back_image = $request->file('national_id_back_image')->store('images');
        }
        if ($request->hasFile('car_license_image')) {
            $trainer->car_license_image = $request->file('car_license_image')->store('images');
        }
    
        $trainer->save();
    
        return redirect()->route('homeTrainer')->with('success', 'Trainer information saved successfully.');
    }
    public function show(){
        // Get the sessions for the logged-in trainer
        $sessions = Session::where('trainer_id', auth()->id())->get();
        
        // Return the view with sessions data
        return view('trainers.sessions', compact('sessions'));
    }
   public function home(){
    return view('trainers.home');
   }
   public function course(){
    return view('trainers.course');
   }
   public function showImage($filename)
{
    $path = storage_path('app/private/images/' . $filename);

    if (file_exists($path)) {
        return response()->file($path);
    } else {
        abort(404); // File not found
    }
}
public function showApplications()
{
    // Fetch the trainer's sessions
    $trainerSessions = Session::where('trainer_id', auth()->id())->get();

    // Fetch the applications for each session, eager load the session relationship
    $applications = SessionApplication::with('session')->whereIn('session_id', $trainerSessions->pluck('id'))->get();

    return view('trainers.applications', compact('applications'));
}

public function approve(Request $request, $applicationId)
{
    $application = SessionApplication::findOrFail($applicationId);
    
    // Update the application status
    $application->status = 'accepted';
    $application->save();

    // Create a message to confirm the session
    Message::create([
        'user_id' => $application->user_id,
        'trainer_id' => $application->session->trainer_id,
        'content' => 'Your application has been approved. Please contact me for further details.'
    ]);

    return redirect()->back()->with('success', 'Application approved and user notified.');
}

public function reject(SessionApplication $application)
{
    $application->status = 'rejected';
    $application->session_id = $application->session_id ?? $application->session->id; // Ensure session_id is set
    $application->save();

    return redirect()->route('home.trainers')->with('error', 'Session Rejected.');
}



}  