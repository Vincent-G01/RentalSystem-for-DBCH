<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Events extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
        
    ];

    public function event_facility_rentals(): HasMany
    {
        return $this->hasMany(Event_Facility_Rental::class, 'events_id');
    }
}
