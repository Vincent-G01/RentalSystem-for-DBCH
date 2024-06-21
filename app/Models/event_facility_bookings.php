<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event_facility_bookings extends Model
{
    use HasFactory;

    protected $fillable =[
            'users_id',
            'halls_id',
            'events_id',
            'rental_type',
            'use_date',
            'total_amount',
            'confirmed',
            'reserved_at',  
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function halls()
    {
        return $this->belongsTo(Halls::class);
    }

    public function events()
    {
        return $this->belongsTo(Events::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facilities::class)
            ->withPivot('quantity');
    }

    public function bookedFacilities()
    {
        return $this->hasMany(Booked_Facility::class, 'event_facility_booking_id');
    }

    
}
