<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Repositories\Interfaces\ForgotPasswordInterface;
use App\Repositories\Interfaces\ResetPasswordInterface;
use App\Helpers\ApiResponse;

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
            return ApiResponse::error('User not found.', 404);
        }

        return ApiResponse::success('OTP sent successfully.');
    }

    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        $this->forgotPasswordRepo->verifyOtp($request->validated());

        return ApiResponse::success('OTP verified successfully.');
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        // This assumes your repo returns user info and token
        $result = $this->resetPasswordRepo->resetPassword($request->only(['email', 'password']));

        return ApiResponse::success('Password reset successfully.', $result);
    }
}
