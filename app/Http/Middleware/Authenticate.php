<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // 1. Untuk request AJAX/JSON, kita kirim error 401 (ini standar)
        if ($request->expectsJson()) {
            return null;
        }

        // 2. Jika user mencoba akses /admin, lempar ke homepage (ini sudah benar)
        if ($request->is('admin') || $request->is('admin/*')) {
            return '/';
        }
        // Jika user (pelanggan) mencoba akses halaman lain (misal /profile)
        // tapi belum login...
        
        // Kita set "sinyal" bernama 'show_login_popup' ke session.
        session()->flash('show_login_popup', true);
        
        // Lalu lempar dia ke homepage
        return '/';
    }
}