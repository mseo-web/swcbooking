<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Resources\BookingResource;
use App\Services\BookingService;

/**
 * @OA\Tag(
 *     name="Bookings",
 *     description="API Endpoints для управления бронированиями"
 * )
 */
class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * @OA\Get(
     *     path="/bookings",
     *     summary="Получить список всех бронирований",
     *     tags={"Bookings"},
     *     security={{"sanctum":{}}},
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
     *     )
     * )
     */
    public function index()
    {
        return BookingResource::collection($this->bookingService->getAllBookings());
    }

    /**
     * @OA\Post(
     *     path="/bookings",
     *     summary="Создать новое бронирование",
     *     tags={"Bookings"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreBookingRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Бронирование успешно создано",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/Booking")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     )
     * )
     */
    public function store(StoreBookingRequest $request)
    {
        $booking = $this->bookingService->createBooking($request->validated());
        return response()->json(new BookingResource($booking), 201);
    }

    /**
     * @OA\Get(
     *     path="/bookings/{id}",
     *     summary="Получить конкретное бронирование",
     *     tags={"Bookings"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID бронирования",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешная операция",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/Booking")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Бронирование не найдено"
     *     )
     * )
     */
    public function show($id)
    {
        return new BookingResource($this->bookingService->getBooking($id));
    }

    /**
     * @OA\Put(
     *     path="/bookings/{id}",
     *     summary="Обновить существующее бронирование",
     *     tags={"Bookings"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID бронирования",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreBookingRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Бронирование успешно обновлено",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/Booking")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Бронирование не найдено"
     *     )
     * )
     */
    public function update(UpdateBookingRequest $request, $id)
    {
        $booking = $this->bookingService->updateBooking($id, $request->validated());
        return new BookingResource($booking);
    }

    /**
     * @OA\Delete(
     *     path="/bookings/{id}",
     *     summary="Удалить бронирование",
     *     tags={"Bookings"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID бронирования",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Бронирование успешно удалено",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Booking deleted"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Бронирование не найдено"
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->bookingService->deleteBooking($id);
        return response()->json(['message' => 'Booking deleted']);
    }
}
