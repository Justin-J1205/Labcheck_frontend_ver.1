<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chemical extends Model
{

    protected $fillable =
    [
        'name',
        'formula',
        'amount',
        'description',
        'safety_info',
        'is_available'
    ];
}
