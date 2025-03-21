<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = "bookings";

    protected $fillable = [
        'resource_id',
        'user_id',
        'start_time',
        'end_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resource() {
        return $this->belongsTo(Resource::class);
    }
}
