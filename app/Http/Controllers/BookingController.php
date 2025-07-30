<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    protected $bookingRepo;
    public function __construct(BookingRepositoryInterface $bookingRepo) {
        $this->bookingRepo = $bookingRepo;
    }

    public function index() {
        $userId = Auth::id();
        return response()->json($this->bookingRepo->userBookings($userId));
    }

    public function store(BookingRequest $request) {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        return response()->json($this->bookingRepo->create($data), 201);
    }
}
