<?php
namespace App\Repositories;

use App\Repositories\Interfaces\RegisterInterface;
use App\Jobs\Auth\RegisterUserJob;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\URL;

class RegisterRepository implements RegisterInterface
{
    public function register(array $data)
    {
        $user = (new RegisterUserJob($data))->handle();
        $payload = [
            'user' => $user,
            'iss'  => URL::secure('/'),
        ];
        $token = JWTAuth::claims($payload)->fromUser($user);
        return [
            'user' => $user,
            'token' => $token,
            'app_url' => URL::secure('/')
        ];
    }
}
