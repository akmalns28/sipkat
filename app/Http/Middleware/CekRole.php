<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {
        // Cek apakah pengguna sudah login dan memiliki peran yang diizinkan
        if (Auth::check() && in_array(Auth::user()->role,$role)) {
            return $next($request);
        }

        // Jika pengguna tidak diizinkan, redirect atau beri respon error
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
