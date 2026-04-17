<?php
namespace App\Http\Middleware;
use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Cek apakah user sudah login
        if (!session('user')) {
            return redirect('/login');
        }

        // Cek apakah role user ada di daftar yang diizinkan
        $userRole = session('user')['role'];
        if (!in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}