<?php

namespace App\Services;

use App\Repositories\Interfaces\BookingRepositoryInterface;

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
        // Здесь можно добавить дополнительную бизнес-логику
        // Например, проверку доступности ресурса
        return $this->repository->create($data);
    }

    public function getBooking($id)
    {
        return $this->repository->findWithResource($id);
    }

    public function updateBooking($id, array $data)
    {
        // Здесь можно добавить проверку конфликтов бронирования
        return $this->repository->update($id, $data);
    }

    public function deleteBooking($id)
    {
        return $this->repository->delete($id);
    }
}