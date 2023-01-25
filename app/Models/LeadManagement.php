<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadManagement extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_lead';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lead_category_id', 'user_id', 'assigned_to','salutation','lead_name','lead_source',
        'cnic', 'email', 'gender','allow_follow_up','lead_value','description','status','company_name','website','office_phone_number',
        'state','city','postal_code','address','group_id'
    ];
}
