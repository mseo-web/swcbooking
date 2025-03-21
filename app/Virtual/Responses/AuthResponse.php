<?php

namespace App\Virtual\Responses;

/**
 * @OA\Schema(
 *     title="Authentication Response",
 *     description="Authentication response with user data and token"
 * )
 */
class AuthResponse
{
    /**
     * @OA\Property(
     *     title="User",
     *     description="User object"
     * )
     * @var object
     */
    public $user;

    /**
     * @OA\Property(
     *     title="Token",
     *     description="Bearer token for API authentication",
     *     example="1|abcdef123456..."
     * )
     * @var string
     */
    public $token;
}