<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Booking;
use App\Models\Resource;
use App\Models\User;
use App\Repositories\BookingRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private BookingRepository $bookingRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookingRepository = new BookingRepository(new Booking());
    }

    // Этот тест проверяет обнаружение пересекающихся бронирований
    public function test_can_detect_overlapping_bookings()
    {
        $resource = Resource::factory()->create();
        $user = User::factory()->create();

        // Создаем существующее бронирование
        Booking::factory()->create([
            'resource_id' => $resource->id,
            'user_id' => $user->id,
            'start_time' => now()->setHour(10),
            'end_time' => now()->setHour(12),
        ]);

        // Проверяем пересечение
        $hasOverlap = $this->bookingRepository->hasOverlappingBookings(
            $resource->id,
            now()->setHour(11),
            now()->setHour(13)
        );

        $this->assertTrue($hasOverlap);
    }

    // Проверяет корректное определение непересекающихся бронирований
    public function test_can_detect_non_overlapping_bookings()
    {
        $resource = Resource::factory()->create();
        $user = User::factory()->create();

        Booking::factory()->create([
            'resource_id' => $resource->id,
            'user_id' => $user->id,
            'start_time' => now()->setHour(10),
            'end_time' => now()->setHour(12),
        ]);

        $hasOverlap = $this->bookingRepository->hasOverlappingBookings(
            $resource->id,
            now()->setHour(13),
            now()->setHour(15)
        );

        $this->assertFalse($hasOverlap);
    }

    // Проверяет исключение текущего бронирования при проверке
    public function test_can_exclude_current_booking_when_checking_overlap()
    {
        $resource = Resource::factory()->create();
        $user = User::factory()->create();

        $booking = Booking::factory()->create([
            'resource_id' => $resource->id,
            'user_id' => $user->id,
            'start_time' => now()->setHour(10),
            'end_time' => now()->setHour(12),
        ]);

        $hasOverlap = $this->bookingRepository->hasOverlappingBookings(
            $resource->id,
            $booking->start_time,
            $booking->end_time,
            $booking->id
        );

        $this->assertFalse($hasOverlap);
    }
}