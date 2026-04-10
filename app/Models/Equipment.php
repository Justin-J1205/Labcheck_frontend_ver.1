<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    // This ensures Laravel looks for equipment
    protected $table = 'equipment';

    protected $fillable = [
        'name',
        'status',
        'quantity',
        'description',
        'is_available'
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
