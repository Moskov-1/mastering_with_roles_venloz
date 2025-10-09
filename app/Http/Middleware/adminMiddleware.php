<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class adminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in');
        }

        if (Auth::check() && !Auth::user()->hasRole("admin")) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            // dd(Auth::user(), Auth::user()->hasRole("admin"));
            return redirect()->route('login')->with("error","Unauthorized");
        }
        
        return $next($request);
    }
}
