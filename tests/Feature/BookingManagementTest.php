<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Booking;
use App\Models\Resource;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(User::factory()->create(), ['*']);
    }

    public function test_can_create_booking()
    {
        $resource = Resource::factory()->create();
        $user = User::factory()->create();
        
        $bookingData = [
            'resource_id' => $resource->id,
            'user_id' => $user->id,
            'start_time' => now()->addHour()->format('Y-m-d H:i:s'),
            'end_time' => now()->addHours(2)->format('Y-m-d H:i:s'),
        ];

        $response = $this->postJson('/api/v1/bookings', $bookingData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'id',
                    'resource_id',
                    'user_id',
                    'start_time',
                    'end_time'
                ]);
    }

    public function test_cannot_create_overlapping_booking()
    {
        $resource = Resource::factory()->create();
        $startTime = now()->addHour();
        $endTime = now()->addHours(2);

        // Создаем первое бронирование
        Booking::factory()->create([
            'resource_id' => $resource->id,
            'start_time' => $startTime,
            'end_time' => $endTime
        ]);

        // Пытаемся создать пересекающееся бронирование
        $response = $this->postJson('/api/v1/bookings', [
            'resource_id' => $resource->id,
            'start_time' => $startTime->addMinutes(30)->format('Y-m-d H:i:s'),
            'end_time' => $endTime->addMinutes(30)->format('Y-m-d H:i:s')
        ]);

        $response->assertStatus(422);
    }

    public function test_can_update_booking()
    {
        $booking = Booking::factory()->create();
        $updateData = [
            'start_time' => now()->addHours(3)->format('Y-m-d H:i:s'),
            'end_time' => now()->addHours(4)->format('Y-m-d H:i:s')
        ];

        $response = $this->putJson("/api/v1/bookings/{$booking->id}", $updateData);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'start_time',
                        'end_time'
                    ]
                ]);
    }

    public function test_can_view_resource_bookings()
    {
        $resource = Resource::factory()->create();
        Booking::factory()->count(3)->create(['resource_id' => $resource->id]);

        $response = $this->getJson("/api/v1/resources/{$resource->id}/bookings");

        $response->assertStatus(200)
                ->assertJsonCount(3, 'data');
    }

    public function test_can_delete_booking()
    {
        $booking = Booking::factory()->create();

        $response = $this->deleteJson("/api/v1/bookings/{$booking->id}");

        $response->assertStatus(200)
                ->assertJson(['message' => 'Booking deleted']);
        
        $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
    }
}