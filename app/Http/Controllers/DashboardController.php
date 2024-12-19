<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Trainer;
use App\Models\Session;
use App\Models\User;
use App\Models\Application;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index() {
        // Gender distribution
        $maleCount = Trainer::where('gender', 'male')->count();
        $femaleCount = Trainer::where('gender', 'female')->count();
    
        // Get count of courses per month
        $courseCounts = Course::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->orderBy('month')
            ->pluck('count', 'month');
    
        // Get count of sessions per month
        $sessionCounts = Session::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->orderBy('month')
            ->pluck('count', 'month');
    
        // Get count of new user registrations per month
        $newUserCounts = User::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->orderBy('month')
            ->pluck('count', 'month');
    
        // Get total registered users over time
        $totalUserCounts = User::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->orderBy('month')
            ->pluck('count', 'month');
    
        // Calculate cumulative user counts
        $cumulativeCounts = [];
        $cumulativeSum = 0;
        foreach ($totalUserCounts as $month => $count) {
            $cumulativeSum += $count;
            $cumulativeCounts[$month] = $cumulativeSum;
        }
    
        // Return the data to the view
        return view('dashboard', compact('maleCount', 'femaleCount', 'courseCounts', 'sessionCounts', 'newUserCounts', 'cumulativeCounts'));
    }
    
    public function pendingCourses()
    {
        $pendingCourses = Course::where('approved', false)->get();
        return view('admin.pending-courses', compact('pendingCourses'));
    }
    public function viewTrainerDetails($trainerId)
{
    $trainer = Trainer::findOrFail($trainerId);
    return view('admin.trainer-details', compact('trainer'));
}
public function showPendingSessions()
{
    $pendingSessions = Session::where('status', 'pending')->get();

    return view('admin.pending-sessions', compact('pendingSessions'));
}
public function showSessionDetails($id)
{
    $session = Session::with(['trainer.user', 'course'])->findOrFail($id);
    return view('admin.session-details', compact('session'));
}
public function showUsers()
{
    // Fetch all users, ordering admins first
    $users = User::orderByRaw("CASE WHEN role = 'admin' THEN 0 ELSE 1 END")->get();

    // Pass the users data to the view
    return view('admin.users-index', compact('users'));
}
}
