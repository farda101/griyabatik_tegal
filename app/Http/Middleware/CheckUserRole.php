<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response // Tambahkan parameter $roles
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            // Jika belum login, redirect ke halaman login
            return redirect()->route('login'); // Pastikan ada route bernama 'login' (dibuat oleh Breeze)
        }

        $user = Auth::user(); // Ambil data pengguna yang sedang login

        // Periksa apakah peran pengguna ada di dalam daftar peran yang diizinkan
        if (! in_array($user->role, $roles)) {
            // Jika tidak memiliki peran yang diizinkan, kembalikan response 403 Forbidden
            // Atau Anda bisa redirect ke halaman lain, misalnya dashboard dengan pesan error.
            abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // Jika peran diizinkan, lanjutkan request
        return $next($request);
    }
}