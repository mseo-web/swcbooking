<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Http\Resources\ResourceResource;
use App\Http\Resources\BookingResource;
use App\Services\ResourceService;

class ResourceController extends Controller
{
    protected $resourceService;

    public function __construct(ResourceService $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function index()
    {
        $resources = $this->resourceService->getAllResources();
        return ResourceResource::collection($resources);
    }

    public function store(StoreResourceRequest $request)
    {
        $resource = $this->resourceService->createResource($request->validated());
        return response()->json(new ResourceResource($resource), 201);
    }

    public function show($id)
    {
        $resource = $this->resourceService->getResource($id);
        return new ResourceResource($resource);
    }

    public function update(UpdateResourceRequest $request, $id)
    {
        $resource = $this->resourceService->updateResource($id, $request->validated());
        return new ResourceResource($resource);
    }

    public function destroy($id)
    {
        $this->resourceService->deleteResource($id);
        return response()->json(['message' => 'Resource deleted']);
    }

    public function bookings($id)
    {
        $bookings = $this->resourceService->getResourceBookings($id);
        return BookingResource::collection($bookings);
    }
}
