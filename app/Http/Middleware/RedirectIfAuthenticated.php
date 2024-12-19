<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): mixed
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                
                // Redirect berdasarkan role
                if (Auth::user()->role == 1) {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('pelanggan.dashboard');
            }
        }

        return $next($request);
    }
} 