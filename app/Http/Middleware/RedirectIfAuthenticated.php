<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Check the authenticated user's role
            $user = Auth::user();
            if ($user->role == 'admin') {
                // Redirect to admin dashboard
                return redirect()->route('admin.dashboard');
            } elseif ($user->role == 'user' || $user->role == 'trainer') {
                // Redirect to user profile
                return redirect()->route('account.profile');
            }
        }

        return $next($request);
    }
}
