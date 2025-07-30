<?php
namespace App\Repositories;

use App\Repositories\Interfaces\ResetPasswordInterface;
use App\Jobs\Auth\ResetPasswordJob;

class ResetPasswordRepository implements ResetPasswordInterface
{
    public function resetPassword(array $data)
    {
        ResetPasswordJob::dispatchSync($data);
        return true;
    }
}
