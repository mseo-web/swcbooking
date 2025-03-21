<?php

namespace App\Virtual\Requests\Auth;

/**
 * @OA\Schema(
 *     title="Register Request",
 *     description="Register request body data"
 * )
 */
class RegisterRequest
{
    /**
     * @OA\Property(
     *     title="Name",
     *     description="User name",
     *     example="John Doe"
     * )
     * @var string
     */
    public $name;

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