<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Resource",
 *     description="Resource model"
 * )
 */
class Resource
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID of the resource",
     *     format="int64",
     *     example=1
     * )
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *     title="Name",
     *     description="Name of the resource",
     *     example="Meeting Room A"
     * )
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *     title="Type",
     *     description="Type of the resource",
     *     example="room"
     * )
     * @var string
     */
    private $type;

    /**
     * @OA\Property(
     *     title="Description",
     *     description="Description of the resource",
     *     example="Large meeting room with projector"
     * )
     * @var string
     */
    private $description;

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