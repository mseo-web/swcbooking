<?php

namespace App\Virtual\Requests\Auth;

/**
 * @OA\Schema(
 *     title="Login Request",
 *     description="Login request body data"
 * )
 */
class LoginRequest
{
    /**
     * @OA\Property(
     *     title="Email",
     *     description="User email",
     *     format="email",
     *     example="user@example.com"
     * )
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *     title="Password",
     *     description="User password",
     *     format="password",
     *     example="password123"
     * )
     * @var string
     */
    public $password;
}