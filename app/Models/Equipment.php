<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'name',
        'status',
        'quantity',
        'description'
    ];

    /**
     * The experiments that use this equipment.
     */
    public function experiments()
    {
        return $this->belongsToMany(Experiment::class)
            ->withPivot('quantity_needed')
            ->withTimestamps();
    }
}
