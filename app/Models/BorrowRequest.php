<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'material_type',
        'material_id',
        'quantity',
        'due_date',
        'status',
        'reason',
        'approved_at',
        'returned_at',
        'is_overdue'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'returned_at' => 'datetime',
        'due_date' => 'datetime',
        'is_overdue' => 'boolean'
    ];

    /**
     * Get the user who made the request
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the requested chemical (if material_type is chemical)
     */
    public function chemical()
    {
        return $this->belongsTo(Chemical::class, 'material_id');
    }

    /**
     * Get the requested equipment (if material_type is equipment)
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'material_id');
    }

    /**
     * Get the material name based on type
     */
    public function getMaterialNameAttribute()
    {
        if ($this->material_type === 'chemical') {
            return $this->chemical?->name ?? 'Deleted Chemical';
        } else {
            return $this->equipment?->name ?? 'Deleted Equipment';
        }
    }
}
