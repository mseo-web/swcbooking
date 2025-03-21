<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="Store Booking Request",
 *     description="Booking request body data"
 * )
 */
class StoreBookingRequest
{
    /**
     * @OA\Property(
     *     title="Resource ID",
     *     description="ID of the resource to book",
     *     format="int64",
     *     example=1
     * )
     * @var integer
     */
    public $resource_id;

    /**
     * @OA\Property(
     *     title="User ID",
     *     description="ID of the user making the booking",
     *     format="int64",
     *     example=1
     * )
     * @var integer
     */
    public $user_id;

    /**
     * @OA\Property(
     *     title="Start Time",
     *     description="Start time of the booking",
     *     format="datetime",
     *     example="2025-03-20 10:00:00"
     * )
     * @var string
     */
    public $start_time;

    /**
     * @OA\Property(
     *     title="End Time",
     *     description="End time of the booking",
     *     format="datetime",
     *     example="2025-03-20 11:00:00"
     * )
     * @var string
     */
    public $end_time;
}