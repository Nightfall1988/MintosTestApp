<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (Auth::check() && $user->two_factor_code) 
        {
            if ($user->two_factor_expires_at->lt(now()))
        {
            $user->resetTwoFactorCode();
            Auth::logout();
        }

        }
        
        return $next($request);
    }
}
