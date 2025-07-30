<?php
namespace App\Repositories\Interfaces;

interface ForgotPasswordInterface
{
    public function sendOtp(string $email);
    public function verifyOtp(array $data);
}
