<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sport_bookings extends Model
{
    use HasFactory;

    protected $fillable = [

        'users_id',
        'halls_id',
        'sports_id',
        'rental_type',
        'use_date',
        'total_amount',
        'confirmed',
        'reserved_at',
       
    ];

    public $timestamps = true;
    
    protected $casts = [
        'confirmed' => 'boolean',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function halls()
    {
        return $this->belongsTo(Halls::class);
    }

    public function sports()
    {
        return $this->belongsTo(Sports::class);
    }
    public function bookedCourts()
    {
        return $this->hasMany(booked_courts::class);
    }

    
}
