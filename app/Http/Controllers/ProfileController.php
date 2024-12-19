<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Illuminate\Support\Facades\Crypt;
use Vonage\Verify\Request as VerifyRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    // Update Profile and Redirect to Phone Verification
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|unique:users,phone,' . auth()->id(),
        ]);
    
        $user = auth()->user();
        $originalPhone = $user->phone;
    
        // Update name and email without changing phone
        $user->update($request->only(['name', 'email']));

        // Check if the phone number was changed
        if ($originalPhone !== $request->input('phone')) {
            // Temporarily store phone number in session for verification
            session(['pending_phone' => $request->input('phone')]);
            
            // Generate a random verification code
            $verificationCode = rand(100000, 999999);
            session(['verification_code' => $verificationCode]);
    
            // Send the verification code via SMS
            $this->sendVerificationSMS($request->input('phone'), $verificationCode);
    
            // Redirect to the verification page
            return redirect()->route('phone.verification')->with('success', 'Phone number updated. Please verify your number.');
        }
    
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // Send the verification code to the user's phone
    public function sendVerificationSMS($phoneNumber) {
        $basic = new \Vonage\Client\Credentials\Basic("c52f25ba","fW55a4RMGGwuP42U");
        $client = new \Vonage\Client($basic);
    
        // Format phone number
        $formattedPhone = $this->formatPhoneNumber($phoneNumber);
        
        try {
            $response = $client->verify()->start(
                new \Vonage\Verify\Request($formattedPhone, '3almny Asoo2')
            );
            
    
            // Store request_id in the session
            session(['request_id' => $response->getRequestId()]);
    
            return response()->json(['message' => 'Verification code sent successfully']);
        } catch (\Exception $e) {
            \Log::error('Error sending SMS:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to send verification code']);
        }
    }
    
    
    
    // Helper function to format the phone number
    private function formatPhoneNumber($phone)
    {
        // Add +2 for Egypt if not already present
        if (substr($phone, 0, 1) == '0') {
            $phone = '+2' . substr($phone, 1);
        }
        return $phone;
    }
    
    

    // Display phone verification page where the user enters the code
    public function verifyPhonePage()
    {
        return view('verify-phone'); // View where user enters verification code
    }

    // Verify the code entered by the user
    public function verifyPhone(Request $request)
    {
        $request->validate([
            'phone_verify_code' => 'required|string|size:4', 
        ]);
    
        // Get request_id from session
        $requestId = session('request_id');
        $inputCode = $request->input('phone_verify_code');
    
        try {
            // Verify the entered code with Vonage
            $basic = new \Vonage\Client\Credentials\Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
            $client = new \Vonage\Client($basic);
    
            $response = $client->verify()->check($requestId, $inputCode);
    
            if ($response->getStatus() == 0) {
                // Code is correct, save phone number
                $user = Auth::user();
                $user->phone = session('pending_phone');
                $user->phone_verified_at = now();
                $user->save();
    
                // Clear session data
                session()->forget(['request_id', 'pending_phone']);
    
                return redirect()->route('account.profile')->with('success', 'Phone number verified successfully.');
            }
    
            return back()->withErrors(['code' => 'The verification code is incorrect.']);
        } catch (\Exception $e) {
            \Log::error('Error verifying code:', ['error' => $e->getMessage()]);
            return back()->withErrors(['code' => 'Verification failed']);
        }
    }
    public function changePassword(Request $request)
    {
        // Validation rules and custom messages
        $request->validate([
            'old_password' => 'required',
            'new_password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#*]).+$/'
            ],
        ],[
            'new_password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@, #, or *).',
            'new_password.confirmed' => 'The new password confirmation does not match.',
        ]);
    
        $user = auth()->user();
    
        // Verify current password
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Current Password is not correct!'])->withInput();
        }
        // Update to the new password
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        return redirect()->route('account.profile')->with('success', 'Password updated successfully!');
    }
    

}
