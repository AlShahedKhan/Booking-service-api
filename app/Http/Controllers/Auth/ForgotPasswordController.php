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
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
                'data' => null,
                'status_code' => 404
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully.',
            'data' => null,
            'status_code' => 200
        ]);
    }

    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        $this->forgotPasswordRepo->verifyOtp($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'OTP verified successfully.',
            'data' => null,
            'status_code' => 200
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        // This assumes your repo returns user info and token
        $result = $this->resetPasswordRepo->resetPassword($request->only(['email', 'password']));

        return response()->json([
            'status' => true,
            'message' => 'Password reset successfully.',
            'data' => $result, // e.g. ['user' => ..., 'token' => ...]
            'status_code' => 200
        ]);
    }
}
