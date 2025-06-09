<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (session('role') !== 'siswa') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        return $next($request);
    }
}
