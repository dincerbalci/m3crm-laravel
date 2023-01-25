<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadFollowUp extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_lead_follow_ups';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'lead_id', 'next_follow_up','remark'
        
    ];
    /**
     * Get the tbl_lead_files ext.
     *
     * @param  string  $value
     * @return string
     */
    public function getNextFollowUpAttribute($value)
    {
        return $this->attributes['next_follow_up'] = Date("m/d/Y h:i:s A", strtotime($value));
    }
     /**
     * Get the tbl_lead_files ext.
     *
     * @param  string  $value
     * @return string
     */
    public function setNextFollowUpAttribute($value)
    {
        return $this->attributes['next_follow_up'] = Date("Y-m-d H:i:s", strtotime($value));
    }
}
