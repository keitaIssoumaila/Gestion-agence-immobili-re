<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfActive
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_active) {
            Auth::logout();

            return redirect()->route('login')->with('error', 'Votre compte a été désactivé.');
        }

        return $next($request);
    }
}
