<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Http\Resources\ResourceResource;
use App\Http\Resources\BookingResource;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Возвращает список всех ресурсов
        return ResourceResource::collection(Resource::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResourceRequest $request)
    {
        // Создаёт новый ресурс
        $resource = Resource::create($request->validated());
        return response()->json($resource, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource)
    {
        // Возвращает информацию о конкретном ресурсе
        return new ResourceResource($resource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResourceRequest $request, Resource $resource)
    {
        // Обновляет ресурс
        $resource->update($request->validated());
        return response()->json($resource);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        // Удаляет ресурс
        $resource->delete();
        return response()->json(['message' => 'Resource deleted']);
    }

    // Если проект небольшой и метод ограничен одной задачей (получение списка бронирований), то размещение в ResourceController — допустимый вариант.
    // Если проект требует чёткого разделения ответственности, или есть планы по развитию функционала бронирования, лучше использовать отдельный контроллер.

    public function bookings($id)
    {
        $resource = Resource::findOrFail($id);
        $bookings = $resource->bookings()->with('user')->get();

        return BookingResource::collection($bookings);
    }
}
