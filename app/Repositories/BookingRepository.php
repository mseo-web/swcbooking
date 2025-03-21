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

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $booking = $this->find($id);
        $booking->update($data);
        return $booking;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}