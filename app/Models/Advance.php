<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'date',
        'project_id',
        'amount_received',
        'received_from',
        'received_by',
        'payment_mode',
        'remarks',
        'attachment',
    ];

    protected $casts = [
        'date' => 'date',
        'amount_received' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}