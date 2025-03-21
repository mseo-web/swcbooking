<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = "resources";

    protected $fillable = [
        'name',
        'type',
        'description',
    ];

    public function bookings() {
        return $this->hasMany(Booking::class);
    }
}
