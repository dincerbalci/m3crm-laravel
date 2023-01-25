<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadFile extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_lead_files';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'lead_id', 'path','ext','size','file_name'
        
    ];
    /**
     * Get the tbl_lead_files ext.
     *
     * @param  string  $value
     * @return string
     */
    public function getExtAttribute($value)
    {
        return $this->attributes['ext'] = strtoupper($value);
    }
    /**
     * Get the tbl_lead_files file_name.
     *
     * @param  string  $value
     * @return string
     */
    public function getFileNameAttribute($value)
    {
        return $this->attributes['file_name'] = ucwords($value);
    }
}
