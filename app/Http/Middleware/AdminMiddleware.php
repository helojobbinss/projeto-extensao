<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // 🔐 verifica se está logado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 🚫 verifica role
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acesso negado. Área restrita para administradores.');
        }

        return $next($request);
    }
}