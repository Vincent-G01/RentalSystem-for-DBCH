<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class booked_facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_facility_booking_id',
        'facility_id',
        'quantity',
        
    ];

    public function eventFacilityBooking()
    {
        return $this->belongsTo(event_facility_bookings::class, 'event_facility_booking_id');
    }

    public function facility()
    {
        return $this->belongsTo(Facilities::class);
    }

    protected $table = 'booked_facility';
}
