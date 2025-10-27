<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabourAttachment extends Model
{
    protected $table = 'labour_attachments';
    
    protected $fillable = [
        'labour_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size'
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    /**
     * Get the labour that owns the attachment.
     */
    public function labour(): BelongsTo
    {
        return $this->belongsTo(Labour::class);
    }
    
    /**
     * Get the URL for the attachment.
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }
}
