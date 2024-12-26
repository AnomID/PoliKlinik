<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
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
        // Check if the session user_role is 'admin'
        if (session('user_role') !== 'admin') {
            return redirect()->route('home')->withErrors(['error' => 'Anda tidak memiliki akses ke halaman admin.']);
        }

        return $next($request);
    }
}
