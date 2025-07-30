<?php

namespace App\Http\Controllers\Auth;

use App\Traits\ApiResponse;
use App\Jobs\Auth\LoginUserJob;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\Interfaces\LoginInterface;

class LoginController extends Controller
{
    use ApiResponse;
    protected $loginRepo;
    public function __construct(LoginInterface $loginRepo)
    {
        $this->loginRepo = $loginRepo;
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $result = $this->loginRepo->login($credentials);
        if (!$result) {
            return $this->unauthorizedResponse('Invalid credentials.');
        }
        $token = $result['token'];
        $user = $result['user'];
        $cookie = cookie('auth_token', $token, 60, '/', null, true, true, false, 'Strict');
        LoginUserJob::dispatch($user->id, now()->toDateTimeString());
        return $this->successResponse('Logged in successfully.', [
            'user' => $user,
            'token' => $token
        ])->withCookie($cookie);
    }
}
