<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Repositories\Interfaces\ForgotPasswordInterface;
use App\Repositories\Interfaces\ResetPasswordInterface;

class ForgotPasswordController extends Controller
{
    protected $forgotPasswordRepo;
    protected $resetPasswordRepo;
    public function __construct(ForgotPasswordInterface $forgotPasswordRepo, ResetPasswordInterface $resetPasswordRepo)
    {
        $this->forgotPasswordRepo = $forgotPasswordRepo;
        $this->resetPasswordRepo = $resetPasswordRepo;
    }
    public function sendOtp(ForgotPasswordRequest $request): JsonResponse
    {
        $result = $this->forgotPasswordRepo->sendOtp($request->email);
        if (!$result) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        return response()->json(['message' => 'OTP sent successfully.']);
    }
    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        $this->forgotPasswordRepo->verifyOtp($request->validated());
        return response()->json(['message' => 'OTP verified successfully.']);
    }
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $this->resetPasswordRepo->resetPassword($request->only(['email', 'password']));
        return response()->json(['message' => 'Password reset successfully.']);
    }
}
