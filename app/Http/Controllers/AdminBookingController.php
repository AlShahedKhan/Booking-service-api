<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\BookingRepositoryInterface;

class AdminBookingController extends Controller
{
    protected $bookingRepo;
    public function __construct(BookingRepositoryInterface $bookingRepo) {
        $this->bookingRepo = $bookingRepo;
    }

    public function index() {
        return response()->json($this->bookingRepo->all());
    }
}
