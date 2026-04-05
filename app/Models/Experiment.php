<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'difficulty',
        'duration_minutes',
        'description',
    ];

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class)
            ->withPivot('quantity_needed') // Prepare for the future!
            ->withTimestamps();
    }

    // Link to Chemicals
    public function chemicals()
    {
        return $this->belongsToMany(Chemical::class)
            ->withPivot('amount_needed')
            ->withTimestamps();
    }
}
