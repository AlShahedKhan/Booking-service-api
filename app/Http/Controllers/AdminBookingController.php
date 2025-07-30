<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Helpers\ApiResponse;

class AdminBookingController extends Controller
{
    protected $bookingRepo;
    public function __construct(BookingRepositoryInterface $bookingRepo) {
        $this->bookingRepo = $bookingRepo;
    }

    public function index() {
        $bookings = $this->bookingRepo->all();
        return ApiResponse::success($bookings, 'All bookings fetched successfully.');
    }
}
