<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;

class BookingController extends Controller
{
    protected $bookingRepo;
    public function __construct(BookingRepositoryInterface $bookingRepo) {
        $this->bookingRepo = $bookingRepo;
    }

    public function index() {
        $userId = Auth::id();
        $bookings = $this->bookingRepo->userBookings($userId);
        return ApiResponse::success($bookings, 'User bookings fetched successfully.');
    }

    public function store(BookingRequest $request) {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $booking = $this->bookingRepo->create($data);
        return ApiResponse::success($booking, 'Booking created successfully.', 201);
    }
}
