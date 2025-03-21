<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="Store Resource Request",
 *     description="Store Resource request body data"
 * )
 */
class StoreResourceRequest
{
    /**
     * @OA\Property(
     *     title="Name",
     *     description="Name of the resource",
     *     example="Meeting Room A"
     * )
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *     title="Type",
     *     description="Type of the resource",
     *     example="room"
     * )
     * @var string
     */
    public $type;

    /**
     * @OA\Property(
     *     title="Description",
     *     description="Description of the resource",
     *     example="Large meeting room with projector",
     *     nullable=true
     * )
     * @var string
     */
    public $description;
}