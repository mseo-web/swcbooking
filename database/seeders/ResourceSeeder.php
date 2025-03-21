<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resource;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = [
            [
                'name' => 'Conference Room',
                'type' => 'room',
                'description' => 'Spacious room for meetings and conferences.',
            ],
            [
                'name' => 'SUV Car',
                'type' => 'car',
                'description' => 'Comfortable SUV for travel and rental.',
            ],
            [
                'name' => 'Office Desk',
                'type' => 'workspace',
                'description' => 'Single desk for daily office work.',
            ],
            [
                'name' => 'Sedan Car',
                'type' => 'car',
                'description' => 'Economical sedan, ideal for city travel.',
            ],
            [
                'name' => 'Private Room',
                'type' => 'room',
                'description' => 'Private room for personal use or rest.',
            ],
        ];

        foreach ($resources as $resource) {
            Resource::create($resource);
        }
    }
}
