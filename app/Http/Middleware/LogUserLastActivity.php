<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LogUserLastActivity
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
        if (Auth::check()) {
            $user = Auth::user();
            $user->last_activity_at = Carbon::now();
            $user->save();

            if(Route::currentRouteName() == 'chat' && !Auth::user()->hasVerifiedEmail()){
                return redirect()->route('profile')->with('error', 'Please verify your email.');
            }
        }

        return $next($request);
    }
}
