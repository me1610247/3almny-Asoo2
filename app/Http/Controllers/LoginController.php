<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }

    public function authenticate(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6', // Add password validation
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('account.login')->withErrors($validator)->withInput();
        }
    
        // Attempt authentication
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // You can safely access Auth::user() here
            $user = Auth::user();
    
            if ($user) {
                // Check user role and redirect accordingly
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->role === 'trainer') {
                    return redirect()->route('home.trainers');
                } elseif ($user->role === 'user') {
                    return redirect()->route('account.home');
                } else {
                    // Handle unexpected role
                    return redirect()->route('account.login')->with('error', 'Unexpected user role');
                }
            }
        }
    
        // If authentication fails
        return redirect()->route('account.login')->with('error', 'Invalid username or password');
    }
    
    

    public function register(){
        return view('register');
    }

    public function Processregister(Request $request){
        // Validate the registration data
        $validated = $request->validate([
            'name'=>'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required', 
                'min:8', 
                'confirmed', 
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#*]).+$/'
            ], // New password rule with regex
        ], [
            // Custom error messages
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@, #, or *).'
        ]);

        // Register the user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'user'; // Default role as 'user'
        $user->save();

        return redirect()->route('account.login')->with('success', 'You have registered successfully');
    }
    public function logout(Request $request)
    {
        // Log the user out of the application
        Auth::logout();

        // Redirect to the login page with a success message
        return redirect()->route('account.login')->with('success', 'You have been logged out successfully.');
    }
    public function registerTrainer()
{
    return view('register-trainer'); // Create a view file for trainer registration
}
public function processTrainerRegistration(Request $request)
{
    $validated = $request->validate([
        'name'=>'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => [
            'required', 
            'min:8', 
            'confirmed', 
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#*]).+$/'
        ], // New password rule with regex
    ], [
        // Custom error messages
        'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@, #, or *).'
    ]);


    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->role = 'trainer';
    $user->save();

    return redirect()->route('account.home')->with('status', 'Trainer account created successfully!');
}

}
