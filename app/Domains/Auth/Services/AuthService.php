<?php

namespace App\Domains\Auth\Services;

use App\Domains\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService
{

    public function loginWeb(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {

            return false;
        }

        $plain = $credentials['password'];

        if (!Hash::check($plain, $user->password)) {
            return false;
        }

        Auth::guard('web')->login($user, true);

 

        return true;
    }
}