<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'material_name',
        'material_type_id',
        'project_id',
        'vendor_name',
        'invoice_number',
        'quantity',
        'unit',
        'unit_price',
        'total_cost',
        'purchase_date',
        'payment_type',
        'payment_notes',
        'upload_bill',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'unit_price' => 'decimal:2',
        'quantity' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    protected $appends = ['formatted_purchase_date'];

    public function getFormattedPurchaseDateAttribute()
    {
        return $this->purchase_date ? $this->purchase_date->format('Y-m-d') : null;
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function materialType()
    {
        return $this->belongsTo(MaterialType::class);
    }

    protected static function booted()
    {
        static::saving(function ($material) {
            if ($material->quantity && $material->unit_price) {
                $material->total_cost = $material->quantity * $material->unit_price;
            }
        });
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}