<?php
namespace App\Repositories;

use App\Repositories\Interfaces\ForgotPasswordInterface;
use App\Models\User;
use Ichtrojan\Otp\Otp;
use App\Jobs\Auth\SendOtpEmailJob;
use App\Jobs\Auth\VerifyOtpJob;

class ForgotPasswordRepository implements ForgotPasswordInterface
{
    public function sendOtp(string $email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return false;
        }
        $otp = (new Otp)->generate($user->email, 'numeric', 6, 10);
        SendOtpEmailJob::dispatch($user->email, $otp->token);
        return true;
    }

    public function verifyOtp(array $data)
    {
        VerifyOtpJob::dispatchSync($data);
        return true;
    }
}
