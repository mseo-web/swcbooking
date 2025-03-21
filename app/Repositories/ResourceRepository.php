<?php

namespace App\Repositories;

use App\Models\Resource;
use App\Repositories\Interfaces\ResourceRepositoryInterface;

class ResourceRepository implements ResourceRepositoryInterface
{
    protected $model;

    public function __construct(Resource $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $resource = $this->find($id);
        $resource->update($data);
        return $resource;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    public function getBookings($id)
    {
        return $this->find($id)->bookings()->with('user')->get();
    }
}