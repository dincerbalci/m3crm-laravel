<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class EFormManagement extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_eform_add';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'daily_counter', 'eform_num', 'agent_id','forward_by','group_id',
        'from_unit_id', 'unit_id', 'user_id','is_approved','product_category',
        'product_id', 'eform_type_id', 'priority_id','status_id','source','progress','file_counter','comments','comments_progress',
        'comments_verified','is_reforward','current_datetime','closed_datetime','forward_datetime','end_datetime','favor','file_path'
    ];
    /**
     * The table associated with the model disable auto created_at and updated_at.
     *
     * @var string
     */
    public $timestamps = false;
    public function getAllEForm($request)
    {
        $cnic=$request->cnic;
        $eFormNumber=$request->form_number;
        $eFormPriority=$request->priority;
        $eFormStatus=$request->status;
        $eFormProduct=$request->product;
        $fromDate=$request->from_date;
        $toDate=$request->to_date;
        $fromDate=str_replace(",","",$fromDate);
        $toDate=str_replace(",","",$toDate);
        $date=array('from_date'=>$fromDate,'to_date'=>$toDate);
        $paginationEnv=env('PAGINATION');
        //44 is adc unit id
        //&& $user_type != 5    previous check
        $userId = Session::get('login_id');
        $unitId = Session::get('unit_id');
        $userType = Session::get('user_type');
        $allEforms = Session::get('all_eforms');
        $dataSession=array('unit_id'=>$unitId,'from_unit_id'=>$unitId,'agent_id'=>$userId,'all_eforms'=>$allEforms,'user_type'=>$userType);
       
        $eFormData= DB::table('tbl_eform_add AS e')
        ->join('tbl_eform_details AS ed', 'ed.eform_id', '=', 'e.id')
        ->leftJoin('tbl_groups AS g', 'g.id', '=', 'e.group_id')
        ->leftJoin('tbl_users AS u', 'u.id', '=', 'e.user_id')
        ->leftJoin('tbl_users AS us', 'us.id', '=', 'e.agent_id')
        ->leftJoin('tbl_status AS s', 's.id', '=', 'e.status_id')
        ->join('tbl_product_category_eform AS pc', 'pc.id', '=', 'e.product_category')
        ->join('tbl_product_eform AS p', 'p.id', '=', 'e.product_id')
        ->join('tbl_eform_type AS ef', 'ef.id', '=', 'e.eform_type_id')
        ->leftJoin('tbl_priority AS pr', 'pr.id', '=', 'e.priority_id')
        ->leftJoin('tbl_org_unit AS br', 'br.id', '=', 'ed.customer_branch_id')
        ->leftJoin('tbl_org_unit AS brass', 'brass.id', '=', 'e.unit_id')
        ->select(DB::raw("e.id,e.file_path,us.user_name released_by ,pr.priority,g.group_name group_fullname,p.fullname product,u.user_name username, pc.fullname category,s.fullname eform_status,ef.fullname eform_type,e.eform_num,e.current_datetime,e.closed_datetime,e.forward_datetime,e.end_datetime,e.is_approved,e.progress,CONCAT(br.unit_name,' (', br.branch_code , ')') branch, br.unit_name branch_name, br.branch_code, e.status_id, e.group_id,e.unit_id,e.product_category,e.product_id,e.eform_type_id,ed.account_no,CONCAT(brass.unit_name,' (', brass.branch_code , ')') assign_branch, ed.customer_name, ed.cnic, e.comments_progress, ed.description"))
        ->when($cnic, function ($query, $cnic) {
          return $query->where('ed.cnic', $cnic);
        })
        ->when($eFormNumber, function ($query, $eFormNumber) {
            return $query->where('e.eform_num', $eFormNumber);
          })
        ->when($eFormPriority, function ($query, $eFormPriority) {
            return $query->where('e.priority_id', $eFormPriority);
        })
        ->when($eFormStatus, function ($query, $eFormStatus) {
            return $query->where('e.status_id', $eFormStatus);
          })
        ->when($eFormProduct, function ($query, $eFormProduct) {
            return $query->where('e.product_id', $eFormProduct);
        })
        ->when($date, function ($query, $date) {
            if($date['from_date'] <> '' && $date['to_date'] <> '')
            {
                $fromDate=Date('Y-m-d',strtotime($date['from_date']));
                $toDate=Date('Y-m-d',strtotime($date['to_date']));
                return $query->whereRaw("DATE(e.current_datetime) BETWEEN '$fromDate'  AND '$toDate'");
            }
        })
        ->when($dataSession, function ($query, $dataSession) {
            if($dataSession['all_eforms'] == '0')
            {
                if ($dataSession['user_type'] != 1 && $dataSession['unit_id'] != 44) {

                if($dataSession['user_type'] == 3) {
				}
				else {
                    $unitId=$dataSession['unit_id'];
                    $userId=$dataSession['agent_id'];
                    return $query->whereRaw("(FIND_IN_SET('$unitId', e.unit_id) OR FIND_IN_SET('$unitId', e.from_unit_id) OR e.agent_id = '$userId')");
				}
            }

            }
        })
        ->orderBy('e.id', 'desc')->paginate($paginationEnv);
        $eFormData->appends(['cnic' => $cnic,'form_number'=>$eFormNumber,
                            'priority'=>$eFormPriority,'status'=>$eFormStatus,
                            'product'=>$eFormProduct,'from_date'=>$fromDate,'to_date'=>$toDate]);
        return $eFormData;
    }
    public function getEFormById($id)
    {
        return DB::select(DB::raw("SELECT ed.*,e.id AS e_form_id,us.user_name released_by,e.source,e.priority_id ,pr.priority,g.group_name group_fullname,p.fullname product,u.user_name username, ed.customer_branch_id,
        s.fullname eform_status,ef.fullname eform_type,e.eform_num,e.current_datetime,e.closed_datetime,e.forward_datetime,e.end_datetime,e.is_approved,e.progress,
        CONCAT(br.unit_name,' (', br.branch_code , ')') branch, e.status_id, e.group_id,e.unit_id,e.product_category,e.product_id,e.eform_type_id,ed.account_no,ed.card_no
        FROM tbl_eform_add e
        LEFT JOIN tbl_eform_details ed ON ed.eform_id = e.id
        LEFT JOIN tbl_groups g ON g.id = e.group_id
        LEFT JOIN tbl_users u ON u.id = e.user_id
        LEFT JOIN tbl_users us ON us.id = e.agent_id
        INNER JOIN tbl_eform_type ef ON ef.id = e.eform_type_id
        LEFT JOIN tbl_product_eform p ON p.id = e.product_id
        LEFT JOIN tbl_status s ON s.id = e.status_id
        LEFT JOIN tbl_priority pr ON pr.id = e.priority_id
        LEFT JOIN tbl_org_unit br ON br.id = ed.customer_branch_id
        WHERE e.id = '$id'"));
    }
    public function getEformActivity($id)
    {
        return DB::select(DB::raw(" SELECT es.*,u.user_name AS activity_performer FROM tbl_eform_status es INNER JOIN tbl_users u ON u.`id`=es.`login_id`
        WHERE es.eform_id='$id'
        ORDER BY update_datetime DESC 
        LIMIT 0, 10"));
    }
}
