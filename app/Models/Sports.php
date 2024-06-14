<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sports extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
        
    ];

    // public function Hall_sports(): HasMany{
    //     return $this -> hasMany(Hall_sports::class, 'sports_id');
    // }
    public function court_rentals(): HasMany
    {
        return $this->hasMany(Court_Rental::class, 'sports_id');
    }


}
