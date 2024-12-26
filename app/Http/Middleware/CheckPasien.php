<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPasien
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
        // Cek jika session pasien_id ada, berarti pasien yang login
        if (!session('pasien_id')) {
            return redirect()->route('pasien.loginForm')->withErrors(['error' => 'Anda tidak memiliki akses ke halaman pasien.']);
        }

        return $next($request);
    }
}
