<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isKaryawan()) {
            return $next($request);
        }
        // abort(403, 'Unauthorized action.');
        return redirect('/login')->with('error', 'Akses ditolak. Anda bukan Karyawan.');
    }
}