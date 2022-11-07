<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EscalationGroup extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_escalation_group';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'is_active', 'created_on'
    ];
    /**
     * The table associated with the model disable auto created_at and updated_at.
     *
     * @var string
     */
    public $timestamps = false;

    public function escalationGroup($search)
    {
        $paginationEnv=env('PAGINATION');
      return  DB::table('tbl_escalation_group AS gr')
        ->join('tbl_escalation_group_users AS gu', 'gu.group_id', '=', 'gr.id')
        ->where('gr.is_active','1')
        ->select(DB::raw('gr.id,gr.full_name group_name,gr.is_active,gr.created_on,GROUP_CONCAT(gu.email) AS email'))
        ->when($search, function ($query, $search) {
            return $query->whereRaw("CONCAT(gr.full_name) like '%$search%'");
        })
        ->groupBy('gr.id')
        ->orderBy('gr.id', 'desc')->paginate($paginationEnv);
    }

}
