<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $authUserRole = Auth::user()->role;
        switch($role){
            case 'admin':
                if($authUserRole == '1'){
                    return $next($request);
                }   
                break;
            case 'pelanggan':
                if($authUserRole == '2'){
                    return $next($request);
            }
            break;
        }

        switch($authUserRole){
            case 1:
                return redirect()->route('admin');
            case 2:
                return redirect()->route('pelanggan');
        }
        return redirect()->route('login');
    }
}
