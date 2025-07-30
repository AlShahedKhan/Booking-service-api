<?php

namespace App\Repositories\Interfaces;

interface BookingRepositoryInterface
{
    public function all();
    public function userBookings($userId);
    public function create(array $data);
}
