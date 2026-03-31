<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (!Auth::check()) {
            return $next($request);
        }

        $timeout = config('session.lifetime') * 60;


        // Check if user's last activity is available and hasn't timed out
        if ($request->session()->has('lastActivityTime') && time() - $request->session()->get('lastActivityTime') > $timeout) {
            Auth::logout(); // Logout user

            // Invalidate the current session and regenerate token
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect to login page with a timeout message
            return redirect('/sign-in')->with('message', 'You have been logged out due to inactivity.');
        }
          // Update user's last activity time
          $request->session()->put('lastActivityTime', time());

          return $next($request);
    }
}
