<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Booking",
 *     description="Booking model"
 * )
 */
class Booking
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID of the booking",
     *     format="int64",
     *     example=1
     * )
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *     title="Resource ID",
     *     description="ID of the booked resource",
     *     format="int64",
     *     example=1
     * )
     * @var integer
     */
    private $resource_id;

    /**
     * @OA\Property(
     *     title="User ID",
     *     description="ID of the user who made the booking",
     *     format="int64",
     *     example=1
     * )
     * @var integer
     */
    private $user_id;

    /**
     * @OA\Property(
     *     title="Start Time",
     *     description="Start time of the booking",
     *     format="datetime",
     *     example="2025-03-20 10:00:00"
     * )
     * @var string
     */
    private $start_time;

    /**
     * @OA\Property(
     *     title="End Time",
     *     description="End time of the booking",
     *     format="datetime",
     *     example="2025-03-20 11:00:00"
     * )
     * @var string
     */
    private $end_time;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     format="datetime",
     *     example="2025-03-20 10:00:00"
     * )
     * @var string
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     format="datetime",
     *     example="2025-03-20 10:00:00"
     * )
     * @var string
     */
    private $updated_at;
}