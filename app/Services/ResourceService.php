<?php

namespace App\Services;

use App\Repositories\Interfaces\ResourceRepositoryInterface;

class ResourceService
{
    protected $repository;

    public function __construct(ResourceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllResources()
    {
        return $this->repository->all();
    }

    public function createResource(array $data)
    {
        return $this->repository->create($data);
    }

    public function getResource($id)
    {
        return $this->repository->find($id);
    }

    public function updateResource($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteResource($id)
    {
        return $this->repository->delete($id);
    }

    public function getResourceBookings($id)
    {
        return $this->repository->getBookings($id);
    }
}