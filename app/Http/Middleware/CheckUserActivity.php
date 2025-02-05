<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = auth()->user()->last_activity;
            $currentTime = Carbon::now();
            $inactiveDuration = $lastActivity->diffInMinutes($currentTime);
            
            if ($inactiveDuration > 15) {
                Auth::logout();
                return redirect()->route('login')->with('message', 'Tu sesión ha expirado debido a inactividad.');
            }
        }

        return $next($request);
    }
}
