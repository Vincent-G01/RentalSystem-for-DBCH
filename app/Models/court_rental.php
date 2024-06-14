<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class court_rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'halls_id',
        'sports_id', 
        'number_of_court',
        'sport_rental_rate'
        
    ];
    
    public function Halls(): BelongsTo
    {
        return $this->belongsTo(Halls::class);
    }
    
    public function Sports(): BelongsTo
    {
        return $this->belongsTo(Sports::class);
    }

    protected $table = 'court_rentals';


}
