<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Attachment extends Model {
    protected $fillable = ['material_id','labour_id','advance_id','file_path','original_name'];
}
