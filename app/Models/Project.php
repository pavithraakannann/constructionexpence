<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'budget',
        'status',
        'location',
        'contact_name',
        'contact_mobile',
        'reference_name',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->project_id)) {
                // Get the latest project ID
                $latest = static::withTrashed()->orderBy('id', 'desc')->first();
                $nextId = $latest ? (int) substr($latest->project_id, 4) + 1 : 1;
                $model->project_id = 'CEMS' . str_pad($nextId, 2, '0', STR_PAD_LEFT);
            }
        });
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // Relationships
    public function labours()
    {
        return $this->hasMany(Labour::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function advances()
    {
        return $this->hasMany(Advance::class);
    }

    // Helper methods for calculations
    public function totalLabourCost()
    {
        return $this->labours()->sum('total_wage');
    }

    public function totalMaterialCost()
    {
        return $this->materials()->sum('total_cost');
    }

    public function totalAdvanceReceived()
    {
        return $this->advances()->sum('amount_received');
    }

    public function totalExpenses()
    {
        return $this->totalLabourCost() + $this->totalMaterialCost();
    }

    public function remainingBudget()
    {
        return $this->budget - $this->totalExpenses();
    }
}