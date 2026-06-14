<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Cek apakah role user saat ini diizinkan mengakses route ini
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika Pelajar/Non-Pelajar nekat masuk area dashboard petugas, lempar ke Home
        return redirect()->route('home')->with('error', 'Anda tidak memiliki hak akses menuju halaman tersebut.');
    }
}