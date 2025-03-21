<?php

namespace App\Services;

use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Events\BookingCreated;
use App\Events\BookingCancelled;

class BookingService
{
    protected $repository;

    public function __construct(BookingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllBookings()
    {
        return $this->repository->getAllWithResource();
    }

    public function createBooking(array $data)
    {
        $booking = $this->repository->create($data);
        event(new BookingCreated($booking));
        return $booking;
    }

    public function getBooking($id)
    {
        return $this->repository->findWithResource($id);
    }

    public function updateBooking($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteBooking($id)
    {
        $booking = $this->repository->find($id);
        $this->repository->delete($id);
        event(new BookingCancelled($booking));
        return true;
    }
}