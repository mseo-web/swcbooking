<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;

class BookingRepository implements BookingRepositoryInterface
{
    protected $model;

    public function __construct(Booking $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function getAllWithResource()
    {
        return $this->model->with('resource')->get();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findWithResource($id)
    {
        return $this->model->with('resource')->findOrFail($id);
    }

    public function hasOverlappingBookings($resourceId, $startTime, $endTime, $excludeBookingId = null)
    {
        $query = $this->model
            ->where('resource_id', $resourceId)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->exists();
    }

    public function create(array $data)
    {
        if ($this->hasOverlappingBookings($data['resource_id'], $data['start_time'], $data['end_time'])) {
            throw new \Exception('This time slot is already booked');
        }
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $booking = $this->find($id);
        if (isset($data['start_time']) && isset($data['end_time'])) {
            if ($this->hasOverlappingBookings(
                $data['resource_id'] ?? $booking->resource_id,
                $data['start_time'],
                $data['end_time'],
                $id
            )) {
                throw new \Exception('This time slot is already booked');
            }
        }
        $booking->update($data);
        return $booking;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}