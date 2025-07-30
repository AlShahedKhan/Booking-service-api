<?php
namespace App\Repositories;

use App\Repositories\Interfaces\LogoutInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LogoutRepository implements LogoutInterface
{
    public function logout()
    {
        Auth::guard('api')->logout();
        return Cookie::forget('auth_token');
    }
}
