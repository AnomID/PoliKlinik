<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDokter
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
        // Cek jika session dokter_id ada, berarti dokter yang login
        if (!session('dokter_id')) {
            return redirect()->route('dokter.loginForm')->withErrors(['error' => 'Anda tidak memiliki akses ke halaman dokter.']);
        }

        return $next($request);
    }
}
