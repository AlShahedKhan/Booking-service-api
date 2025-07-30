<?php
namespace App\Repositories;

use App\Repositories\Interfaces\LoginInterface;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\URL;

class LoginRepository implements LoginInterface
{
    public function login(array $credentials)
    {
        if (!$token = Auth::attempt($credentials)) {
            return false;
        }
        $user = Auth::user();
        $payload = [
            'user' => $user,
            'iss'  => URL::secure('/'),
        ];
        $token = JWTAuth::claims($payload)->fromUser($user);
        return [
            'token' => $token,
            'user' => $user
        ];
    }
}
