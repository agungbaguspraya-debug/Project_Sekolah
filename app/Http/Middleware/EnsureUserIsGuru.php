<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsGuru
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && (auth()->user()->role === 'guru' || auth()->user()->role === 'admin')) {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Halaman ini hanya dapat diakses oleh Guru.');
    }
}
