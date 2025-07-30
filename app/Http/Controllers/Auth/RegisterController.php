<?php

namespace App\Http\Controllers\Auth;

use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Repositories\Interfaces\RegisterInterface;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use ApiResponse;
    protected $registerRepo;
    public function __construct(RegisterInterface $registerRepo)
    {
        $this->registerRepo = $registerRepo;
    }
    public function register(RegistrationRequest $request)
    {
        return $this->safeCall(function () use ($request) {
            $result = $this->registerRepo->register($request->validated());
            $user = $result['user'];
            $token = $result['token'];
            $cookie = cookie('auth_token', $token, 60, '/', null, true, true, false, 'Strict');
            return $this->successResponse('User registered successfully', [
                'user' => $user,
                'token' => $token,
                'app_url' => $result['app_url'],
            ])->withCookie($cookie);
        });
    }
}
