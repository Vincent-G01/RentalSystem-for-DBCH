<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Halls extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'diagram',
        'cities_id',
        'capacity',
        'maintainance_status',
        'maintainance_start_date',
        'maintainance_end_date',
        'address',
        'users_id',
    ];

    protected $table = 'halls';

    // public function City(): BelongsTo
    // {
    //     return $this->belongsTo(City::class);
    // }


    // public function Hall_sports(): HasMany
    // {
    //     return $this->hasMany(Hall_sports::class, 'halls_id');
    // }

    public function Users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function courtRentals(): HasMany
    {
        return $this->hasMany(Court_Rental::class, 'halls_id');
    }

    // Define the relationship for events
    public function eventFacilityRentals(): HasMany
    {
        return $this->hasMany(Event_Facility_Rental::class, 'halls_id');
    }




   
}
