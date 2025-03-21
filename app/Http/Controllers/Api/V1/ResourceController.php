<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Http\Resources\ResourceResource;
use App\Http\Resources\BookingResource;
use App\Services\ResourceService;

/**
 * @OA\Tag(
 *     name="Resources",
 *     description="API Endpoints для управления ресурсами"
 * )
 */
class ResourceController extends Controller
{
    protected $resourceService;

    public function __construct(ResourceService $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    /**
     * @OA\Get(
     *     path="/resources",
     *     summary="Получить список ресурсов",
     *     tags={"Resources"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Успешная операция",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Resource")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $resources = $this->resourceService->getAllResources();
        return ResourceResource::collection($resources);
    }

    /**
     * @OA\Post(
     *     path="/resources",
     *     summary="Создать новый ресурс",
     *     tags={"Resources"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreResourceRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ресурс успешно создан",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/Resource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     )
     * )
     */
    public function store(StoreResourceRequest $request)
    {
        $resource = $this->resourceService->createResource($request->validated());
        return response()->json(new ResourceResource($resource), 201);
    }

    /**
     * @OA\Get(
     *     path="/resources/{id}",
     *     summary="Получить конкретный ресурс",
     *     tags={"Resources"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID ресурса",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешная операция",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/Resource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ресурс не найден"
     *     )
     * )
     */
    public function show($id)
    {
        $resource = $this->resourceService->getResource($id);
        return new ResourceResource($resource);
    }

    /**
     * @OA\Put(
     *     path="/resources/{id}",
     *     summary="Обновить существующий ресурс",
     *     tags={"Resources"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID ресурса",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreResourceRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ресурс успешно обновлен",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/Resource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ресурс не найден"
     *     )
     * )
     */
    public function update(UpdateResourceRequest $request, $id)
    {
        $resource = $this->resourceService->updateResource($id, $request->validated());
        return new ResourceResource($resource);
    }

    /**
     * @OA\Delete(
     *     path="/resources/{id}",
     *     summary="Удалить ресурс",
     *     tags={"Resources"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID ресурса",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ресурс успешно удален",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Resource deleted"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ресурс не найден"
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->resourceService->deleteResource($id);
        return response()->json(['message' => 'Resource deleted']);
    }

    /**
     * @OA\Get(
     *     path="/resources/{id}/bookings",
     *     summary="Получить бронирования ресурса",
     *     tags={"Resources"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID ресурса",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешная операция",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Booking")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ресурс не найден"
     *     )
     * )
     */
    public function bookings($id)
    {
        $bookings = $this->resourceService->getResourceBookings($id);
        return BookingResource::collection($bookings);
    }
}
