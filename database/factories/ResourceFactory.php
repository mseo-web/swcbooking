<?php

namespace Database\Factories;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceFactory extends Factory
{
    protected $model = Resource::class;

    public function definition()
    {
        return [
            'name' => fake()->unique()->word() . ' Room',
            'type' => fake()->randomElement(['room', 'equipment', 'vehicle']),
            'description' => fake()->sentence(),
        ];
    }
}