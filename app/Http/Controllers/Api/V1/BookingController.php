<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Resources\BookingResource;
use App\Services\BookingService;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        return BookingResource::collection($this->bookingService->getAllBookings());
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = $this->bookingService->createBooking($request->validated());
        return response()->json(new BookingResource($booking), 201);
    }

    public function show($id)
    {
        return new BookingResource($this->bookingService->getBooking($id));
    }

    public function update(UpdateBookingRequest $request, $id)
    {
        $booking = $this->bookingService->updateBooking($id, $request->validated());
        return new BookingResource($booking);
    }

    public function destroy($id)
    {
        $this->bookingService->deleteBooking($id);
        return response()->json(['message' => 'Booking deleted']);
    }
}
