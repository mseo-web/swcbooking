<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Events\BookingCancelled;
use Illuminate\Support\Facades\Log;

class SendBookingNotification
{
    public function handleBookingCreated(BookingCreated $event)
    {
        // Здесь логика отправки уведомления о создании бронирования
        // Например, отправка email, пока Log::info()
        Log::info("Booking created: {$event->booking->id}");
    }

    public function handleBookingCancelled(BookingCancelled $event)
    {
        // Здесь логика отправки уведомления об отмене бронирования
        Log::info("Booking cancelled: {$event->booking->id}");
    }
}