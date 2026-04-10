<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chemical extends Model
{
    use HasFactory;

    // CRITICAL: You must add 'formula' to this array!
    protected $fillable = [
        'name',
        'formula',
        'amount',
        'safety_info',
        'is_available'
    ];
}
