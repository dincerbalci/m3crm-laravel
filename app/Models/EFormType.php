<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EFormType extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_eform_type';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id', 'product_category_id', 'product_id','fullname','tat','operation_mode','isactive','is_subscription','created_on',
        'updated_on'
    ];
    /**
     * The table associated with the model disable auto created_at and updated_at.
     *
     * @var string
     */
    public $timestamps = false;
   
    public function eFormType($search)
    {
        $paginationEnv=env('PAGINATION');
      return  DB::table('tbl_eform_type AS t')
        ->join('tbl_product_eform AS p', 't.product_id', '=', 'p.id')
        ->join('tbl_product_category_eform AS pc', 'pc.id', '=', 't.product_category_id')
        ->select(DB::raw('t.*,p.fullname AS product_name,pc.fullname AS category_name'))
        ->when($search, function ($query, $search) {
            return $query->whereRaw("CONCAT(t.fullname,p.fullname,pc.fullname) like '%$search%'");
        })
        
        ->orderBy('t.id', 'desc')->paginate($paginationEnv);
    }
    public function GetUsers()
    {
        return DB::select(DB::raw("SELECT u.* ,t.group_name user_type_name, CONCAT(b.unit_name,' (',b.branch_code,')') branch_name,
        (SELECT GROUP_CONCAT(r.primary_name) FROM tbl_roles r INNER JOIN tbl_users_role ur ON r.id = ur.role_id WHERE ur.user_id = u.id) role_name
        FROM tbl_users u
        LEFT JOIN tbl_groups t ON u.group_id = t.id
        LEFT JOIN tbl_org_unit b ON b.id = u.unit_id
        WHERE u.id != '1'"));
    }
     
}
