<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        return [
            'resource_id' => Resource::factory(),
            'user_id' => User::factory(),    // Changed from hardcoded 1 to User factory
            'start_time' => fake()->dateTimeBetween('now', '+1 week'),
            'end_time' => fake()->dateTimeBetween('+1 week', '+2 weeks'),
        ];
    }
}