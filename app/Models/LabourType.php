<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabourType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'standard_rate',
        'unit',
        'is_active'
    ];

    protected $casts = [
        'standard_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Add any relationships here if needed
}
