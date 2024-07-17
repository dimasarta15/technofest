<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Auth;
use Closure;
use Illuminate\Http\Request;

class ParticipantVerified
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
        if (Auth::user()->role_id == Role::ROLES['participant']) {
            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                return redirect()->route('login')->with('error_msg', 'Anda belum melakukan aktivasi !');
            }
        }
        
        return $next($request);
    }
}
