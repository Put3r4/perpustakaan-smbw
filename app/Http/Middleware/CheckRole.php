<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Pastikan user sudah login
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // 2. Superadmin selalu punya akses ke semua hal
        if ($request->user()->role === 'superadmin') {
            return $next($request);
        }

        // 3. Cek apakah role user saat ini diizinkan mengakses route ini
        if (in_array($request->user()->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, lempar error 403 (Unauthorized)
        abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
    }
}