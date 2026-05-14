<?php
namespace App\Domains\Auth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Domains\Auth\Services\AuthService;

class AuthController
{
    public function login(Request $request, AuthService $service)
    {
        $credentials = $request->only('email', 'password');

        if (!$service->loginWeb($credentials)) {
            return back()->withErrors([
                'email' => 'Credenciais inválidas'
            ]);
        }

        // 🔍 DEBUG VISUAL (temporário)
        logger()->info('CONTROLLER DEBUG', [
            'auth_check' => Auth::check(),
            'auth_user' => Auth::user(),
        ]);

        $request->session()->regenerate();

        return redirect()->route('projects');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}