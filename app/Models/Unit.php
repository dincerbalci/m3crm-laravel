<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Unit extends Model
{
    use HasFactory;
      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_org_unit';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id', 'region_id', 'branch_code','unit_name','address','email','is_active','created_by','created_on','updated_by','updated_on'
    ];
    /**
     * The table associated with the model disable auto created_at and updated_at.
     *
     * @var string
     */
    public $timestamps = false;
    public function escalationGroup()
    {
      return  DB::table('tbl_escalation_group AS gr')
        ->join('tbl_escalation_group_users AS gu', 'gu.group_id', '=', 'gr.id')
        ->where('gr.is_active','1')
        ->select(DB::raw('gr.id,gr.full_name group_name,gr.is_active,gr.created_on,GROUP_CONCAT(gu.email) AS email'))
        ->groupBy('gr.id')
        ->orderBy('gr.id', 'desc')->get();
    }

}
