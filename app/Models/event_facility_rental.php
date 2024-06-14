<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class event_facility_rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'halls_id',
        'events_id',
        'event_rental_rate',
        'facilities_id', 
        'quantity',
        'facility_rental_rate'
        
    ];

    public function Halls(): BelongsTo
    {
        return $this->belongsTo(Halls::class);
    }
    
    public function Events(): BelongsTo
    {
        return $this->belongsTo(Events::class);
    }

    public function Facilities(): BelongsTo
    {
        return $this->belongsTo(Facilities::class);
    }

    protected $table = 'event_facility_rentals';
}

