<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\LogoutInterface;

class LogoutController extends Controller
{
    protected $logoutRepo;
    public function __construct(LogoutInterface $logoutRepo)
    {
        $this->logoutRepo = $logoutRepo;
    }
    public function logout(): JsonResponse
    {
        $cookie = $this->logoutRepo->logout();
        return response()->json(['message' => 'Successfully logged out.'])->withCookie($cookie);
    }
}
