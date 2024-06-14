<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'court_rental_id',
        'available'
    ];

    public function courtRental()
    {
        return $this->belongsTo(Court_Rental::class, 'court_rental_id');
    }
    
}
