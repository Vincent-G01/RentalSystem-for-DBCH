<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends Model
{

    use HasFactory;
    protected $fillable = [
        'name'
        
    ];

    protected $table = 'roles'; // jika nama model awak tak sama dengan nama table jadi awak kena tambah line ini untuk dia tahu bahawa model ini merujuk kepada table di dalam database awak
   
    // saya bagi tips sikit 
    // kalau awak buat model pastikan nama model awak sama dengan nama table awak di dalam database
    // kalau awak dah buat model yang tidak mengikut nama table dalam database awak boleh guna code dalam line 18 
}
