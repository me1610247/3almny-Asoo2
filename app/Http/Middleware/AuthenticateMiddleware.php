<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
            // Redirect based on the guard
            if (!Auth::guard('trainer')->check()) {          
               return redirect()->route('trainer.login');
            } elseif (!Auth::guard('trainee')->check()) {
                return redirect()->route('trainee.login');
            }

            // Default redirect for unauthenticated requests
            return redirect()->route('account.login');
        

        return $next($request);
    }
}
