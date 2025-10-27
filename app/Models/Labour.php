<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Labour extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'date',
        'project_id',
        'labour_type_id',
        'labour_name',
        'num_workers',
        'wage_per_worker',
        'total_wage',
        'payment_mode',
        'remarks'
    ];
    
    protected $with = ['attachments'];

    protected $casts = [
        'date' => 'date',
        'num_workers' => 'integer',
        'wage_per_worker' => 'decimal:2',
        'total_wage' => 'decimal:2',
    ];

    protected $enums = [
        'payment_mode' => [
            'Cash',
            'UPI',
            'Bank',
            'Other'
        ]
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
    public function labourType()
    {
        return $this->belongsTo(LabourType::class);
    }
    
    /**
     * Get all attachments for the labour record.
     */
    public function attachments()
    {
        return $this->hasMany(LabourAttachment::class);
    }

    public function getPaymentModeOptions()
    {
        return $this->enums['payment_mode'];
    }
}
