<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;  // <--- Importar Session

class AuthCheck
{
    public function handle(Request $request, Closure $next)
    {
        $user = Session::get('user');

        if (!$user || !($user['accesoTotal'] ?? false)) {
            return redirect()->route('login.form');
        }

        return $next($request);
    }
}
