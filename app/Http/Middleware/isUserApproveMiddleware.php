<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isUserApproveMiddleware
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
        if(auth()->check()) {
            if(!auth()->user()->is_approved) {

                auth()->logout();

                $request->session()->invalidate();
            
                $request->session()->regenerateToken();
            
                return redirect('/')->withErrors('Your account needs an administrator approval in order to login');
            }
        }

        return $next($request);
    }
}
