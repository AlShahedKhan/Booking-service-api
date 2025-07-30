<?php

namespace App\Repositories;

use App\Interfaces\BookingRepositoryInterface;
use App\Models\Booking;

class BookingRepository implements BookingRepositoryInterface
{
    public function all() { return Booking::with(['user', 'service'])->get(); }
    public function userBookings($userId) {
        return Booking::where('user_id', $userId)->with('service')->get();
    }
    public function create(array $data) { return Booking::create($data); }
}
