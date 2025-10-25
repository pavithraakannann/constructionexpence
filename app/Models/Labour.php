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
        'labour_category',
        'labour_name',
        'num_workers',
        'wage_per_worker',
        'total_wage',
        'payment_mode',
        'remarks',
        'attachment'
    ];

    protected $casts = [
        'date' => 'date',
        'num_workers' => 'integer',
        'wage_per_worker' => 'decimal:2',
        'total_wage' => 'decimal:2',
    ];

    protected $enums = [
        'labour_category' => [
            'Mason / Bricklayer',
            'Carpenter',
            'Electrician',
            'Plumber',
            'Helper / Labourer',
            'Foreman / Supervisor',
            'Other'
        ],
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

    public function getLabourCategoryOptions()
    {
        return $this->enums['labour_category'];
    }

    public function getPaymentModeOptions()
    {
        return $this->enums['payment_mode'];
    }
}
