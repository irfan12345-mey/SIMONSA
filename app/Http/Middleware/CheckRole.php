<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Middleware 'auth' sudah menangani guest, jadi di sini kita asumsikan user sudah login.
        // Namun tetap aman jika suatu saat dipakai tanpa 'auth'.
        if (!$request->user() || !in_array($request->user()->role, $roles, true)) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        return $next($request);
    }
}