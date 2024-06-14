<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class booked_courts extends Model
{
    use HasFactory;
    protected $fillable = [
        'sport_bookings_id',
        'court_number',
        'start_time',
        'end_time',
        
    ];

    public function sport_bookings()
    {
        return $this->belongsTo(sport_bookings::class);
    }

    public function court_rental()
    {
        return $this->belongsTo(court_rental::class);
    }



    
}
