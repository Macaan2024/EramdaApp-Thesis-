<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NurseChiefMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Check if user is logged in and is an Admin
        if (Auth::check() && Auth::user()->user_type === 'Nurse Chief') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Access denied.');
    }
}
