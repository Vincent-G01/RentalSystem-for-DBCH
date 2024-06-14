<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facilities extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
        
    ];


    // public function eventFacilityRentals()
    // {
    //     return $this->hasMany(event_facility_rental::class, 'facilities_id');
    // }
    public function event_facility_rentals()
    {
        return $this->hasMany(event_facility_rental::class, 'facilities_id');
    }
 

    

}
