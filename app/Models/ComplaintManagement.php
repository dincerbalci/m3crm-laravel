<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ComplaintManagementController;

class ComplaintManagement extends Model
{
    use HasFactory;
      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_complaints';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'daily_counter', 'complaint_num', 'agent_id','forward_by','group_id',
        'from_unit_id', 'unit_id', 'user_id','is_approved','product_category',
        'product_id', 'complaint_type_id', 'priority_id','status_id','source','progress','file_counter','comments','comments_progress',
        'comments_verified','create_date','end_date','forward_date','close_date','update_date','favor','close_notes','amount'
    ];
    /**
     * The table associated with the model disable auto created_at and updated_at.
     *
     * @var string
     */
    public $timestamps = false;
    protected $primaryKey = 'complaint_id';
    public function getComplaint($request)
    {
        $cnic=$request->cnic;
        $compNum=$request->complaint_number;
        $compPriority=$request->priority;
        $callBack=$request->call_back_phone;
        $compStatus=$request->complaint_status;
        $compProduct=$request->product;
        $complainId=$request->complaint_id;
        $fromDate=$request->from_date;
        $toDate=$request->to_date;
        $fromDate=str_replace(",","",$fromDate);
        $toDate=str_replace(",","",$toDate);
        $date=array('from_date'=>$fromDate,'to_date'=>$toDate,'comp_status'=>$compStatus);
        $userId = Session::get('login_id');
        $role_id = Session::get('role_id');
        $unitId = Session::get('unit_id');
        $userType = Session::get('user_type');
        $allComplaints = Session::get('all_complaints');
        $dataSession=array('unit_id'=>$unitId,'from_unit_id'=>$unitId,'agent_id'=>$userId,'all_complaints'=>$allComplaints,'user_type'=>$userType);
        $paginationEnv=env('PAGINATION');
        
        $complaint= DB::table('tbl_complaints AS c')
        ->leftJoin('tbl_complaint_details AS d', 'd.complaint_id', '=', 'c.complaint_id')
        ->leftJoin('tbl_users AS u', 'c.agent_id', '=', 'u.id')
        ->leftJoin('tbl_priority AS pr', 'pr.id', '=', 'c.priority_id')
        ->leftJoin('tbl_status AS s', 'c.status_id', '=', 's.id')
        ->leftJoin('tbl_product_category AS pc', 'pc.id', '=', 'c.product_category')
        ->leftJoin('tbl_product AS pp', 'pp.id', '=', 'c.product_id')
        ->join('tbl_complaint_type AS ct', 'c.complaint_type_id', '=', 'ct.id')
        ->leftJoin('tbl_groups AS g', 'c.group_id', '=', 'g.id')
        ->leftJoin('tbl_users AS us', 'us.id', '=', 'c.user_id')
        ->leftJoin('tbl_org_unit AS br', 'br.id', '=', 'd.customer_branch_id')
        ->leftJoin('tbl_org_unit AS brass', 'brass.id', '=', 'c.unit_id')
        ->select(DB::raw("c.complaint_id, c.daily_counter, c.complaint_num,c.agent_id,c.group_id,c.unit_id,c.user_id,c.product_category,c.product_id,c.complaint_type_id,c.priority_id,c.status_id,c.progress,c.file_counter,c.comments,c.comments_progress, c.is_approved,c.comments_verified,c.create_date,c.end_date,c.forward_date,c.close_date,us.user_name users,u.user_name agent_name, g.group_name group_fullname, ct.tat,pr.priority,s.fullname complaint_status, c.source, pc.fullname product_category_name, pp.fullname product_name, ct.fullname complaint_type, ct.tat complaint_type_tat, CONCAT(br.unit_name,' (', br.branch_code , ')') branch,d.compl_title,d.customer_name,d.cnic,d.mother_maiden,d.dob,d.account_no,d.complaint_nature,d.channel,d.description,d.callback_num,d.delivery_address,d.residence_address,d.is_email,d.customer_email,d.is_sms,d.response_number,d.is_call_back,d.customer_branch_id, CONCAT(brass.unit_name,' (', brass.branch_code , ')') assign_branch"))
        ->when($cnic, function ($query, $cnic) {
          return $query->where('d.cnic', $cnic);
        })
        ->when($compNum, function ($query, $compNum) {
            return $query->where('c.complaint_num', $compNum);
          })
        ->when($compPriority, function ($query, $compPriority) {
            return $query->where('c.priority_id', $compPriority);
        })
        ->when($callBack, function ($query, $callBack) {
            return $query->where('d.callback_num', $callBack);
          })
        ->when($compStatus, function ($query, $compStatus) {
            return $query->where('c.status_id', $compStatus);
        })
        ->when($compProduct, function ($query, $compProduct) {
            return $query->where('c.product_id', $compProduct);
        })
        ->when($complainId, function ($query, $complainId) {
            return $query->where('c.complaint_id', $complainId);
        })
        ->when($date, function ($query, $date) {
            if($date['from_date'] <> '' && $date['to_date'] <> '')
            {

                if($date['comp_status'] == 3){
                    return $query->whereBetween('c.close_date', [DATE('Y-m-d',strtotime($date['from_date'])),DATE('Y-m-d',strtotime($date['to_date']))]);
                }
                else{

                    return $query->whereBetween('c.create_date', [DATE('Y-m-d',strtotime($date['from_date'])),DATE('Y-m-d',strtotime($date['to_date']))]);
                }
            }
        })
        ->when($dataSession, function ($query, $dataSession) {
            if($dataSession['all_complaints'] == '0')
            {
                if ($dataSession['user_type'] != 1 && $dataSession['user_type'] != 2) {

                if($dataSession['user_type'] == 3) {
				}
				else {
                    $unitId=$dataSession['unit_id'];
                    $userId=$dataSession['agent_id'];
                    return $query->whereRaw("(c.unit_id IN ($unitId) OR c.from_unit_id IN ($unitId) OR c.agent_id = $userId)");
				}
            }

            }
        })
        ->orderBy('c.complaint_id', 'desc')->paginate($paginationEnv);
        $complaint->appends(['cnic' => $cnic,'complaint_num'=>$compNum,
                            'priority'=>$compPriority,'call_back_phone'=>$callBack,
                            'complaint_status'=>$compStatus,'product'=>$compProduct,'from_date'=>$fromDate,'to_date'=>$toDate]);
        return $complaint;

    }
    public function getComplaintEscalation($request)
    {
        $paginationEnv=env('PAGINATION');
        $complaintNum=$request->complaint_number;
        $fromDate=$request->from_date;
        $toDate=$request->to_date;
        $userId = Session::get('login_id');
        $unitId = Session::get('unit_id');
        $userType = Session::get('user_type');
        $dataSession=array('unit_id'=>$unitId,'agent_id'=>$userId,'user_type'=>$userType);
        $fromDate=str_replace(",","",$fromDate);
        $toDate=str_replace(",","",$toDate);
        $date=array('from_date'=>$fromDate,'to_date'=>$toDate);
        $complaint= DB::table('tbl_complaints AS c')
        ->join('tbl_emails_comp_eform_save AS emails', 'emails.comp_eform_id', '=', 'c.complaint_id')
        ->leftJoin('tbl_complaint_details AS d', 'd.complaint_id', '=', 'c.complaint_id')
        ->leftJoin('tbl_users AS u', 'c.agent_id', '=', 'u.id')
        ->leftJoin('tbl_priority AS pr', 'pr.id', '=', 'c.priority_id')
        ->leftJoin('tbl_status AS s', 'c.status_id', '=', 's.id')
        ->leftJoin('tbl_product_category AS pc', 'pc.id', '=', 'c.product_category')
        ->leftJoin('tbl_product AS pp', 'pp.id', '=', 'c.product_id')
        ->join('tbl_complaint_type AS ct', 'c.complaint_type_id', '=', 'ct.id')
        ->leftJoin('tbl_users AS us', 'us.id', '=', 'c.user_id')
        ->leftJoin('tbl_org_unit AS br', 'br.id', '=', 'd.customer_branch_id')
        ->leftJoin('tbl_org_unit AS lodgeby', 'lodgeby.id', '=', 'c.from_unit_id')
        ->leftJoin('tbl_source AS sor', 'sor.id', '=', 'c.source')
        ->select(DB::raw("c.complaint_id, c.complaint_num, CONCAT(br.unit_name,' (', br.branch_code , ')') customer_branch, c.create_date, c.close_date, d.compl_title, d.customer_name, d.cnic, sor.source_name,
        CONCAT(lodgeby.unit_name,' (', lodgeby.branch_code , ')') lodge_by, d.description, pc.fullname product_category_name, pp.fullname product_name, ct.fullname complaint_type, ct.tat,
        c.status_id, s.fullname complaint_status, c.end_date, (SELECT CONCAT(SUBSTR(tbl_emails_comp_eform_save.template_subject,6,7),'|',tbl_emails_comp_eform_save.`datetime`)
        FROM tbl_emails_comp_eform_save WHERE tbl_emails_comp_eform_save.comp_eform_id = c.complaint_id AND tbl_emails_comp_eform_save.`type` = 'complaint_escalation' ORDER BY tbl_emails_comp_eform_save.template_subject DESC LIMIT 1) current_escalation_level"))
        ->when($dataSession, function ($query, $dataSession) {
            if($dataSession['user_type'] != 1 && $dataSession['user_type'] != 2)
            {
                $unitId=$dataSession['unit_id'];
                $userId=$dataSession['agent_id'];
                return $query->whereRaw("AND c.unit_id IN ($unitId) OR c.from_unit_id IN ($unitId) OR c.agent_id = '$userId'");
            }
          })
        ->when($date, function ($query, $date) {
            if($date['from_date'] != '' && $date['to_date'] != '')
            {
                $fromDate=date("Y-m-d",strtotime($date['from_date']));
                $toDate=date("Y-m-d",strtotime($date['to_date']));
                return $query->whereRaw("DATE(emails.datetime) BETWEEN '$fromDate' AND '$toDate'");
            }
        })
        ->when($complaintNum, function ($query, $complaintNum) {
          return $query->where('c.complaint_num', $complaintNum);
        })
        ->where('emails.type','complaint_escalation')
        ->groupBy('c.complaint_id')
        ->orderBy('c.complaint_id', 'desc')->paginate($paginationEnv);
        $complaint->appends(['complaint_number' => $complaintNum,'from_date'=>$fromDate,'to_date'=>$toDate]);
        return $complaint;
    }
    public function GenComplaintCounter()
    {
        $first_digit = "CT";
        $today = date("Y-m-d");
        $date_part = date("ymd");

        $row=DB::select(DB::raw("SELECT IFNULL(MAX(daily_counter)+1,1) AS daily_counter FROM `tbl_complaints` WHERE DATE(`create_date`) = '$today'"));
        $second_digit = sprintf('%03d', (int)$row[0]->daily_counter);
        $next_counter = $first_digit.$date_part.$second_digit;
        return $next_counter."|".$row[0]->daily_counter;
    }
    public function GetDuplicateComplaint($cnic,$category_id,$product_id,$type_id){

        //get only initiated and in-progress complaints for checking duplicate
        return DB::select(DB::raw("SELECT c.complaint_num, d.compl_title, d.cnic, c.progress, pr.priority, c.status_id, s.fullname complaint_status, c.create_date, DATE(c.end_date) end_date
        FROM  tbl_complaints c
        INNER JOIN tbl_complaint_details d ON d.complaint_id = c.complaint_id
        LEFT JOIN tbl_priority pr ON pr.id = c.priority_id
        LEFT JOIN tbl_status s ON c.status_id = s.id
        WHERE d.cnic = '$cnic' AND c.product_category = '$category_id' AND c.product_id = '$product_id' AND c.complaint_type_id = '$type_id' AND c.status_id IN (1,2,4)
        ORDER BY c.complaint_id DESC LIMIT 5"));

    }
    public function CheckSMSEmail($complaintId)
    {
        return DB::select(DB::raw("SELECT is_sms, is_email, response_number customer_mobile_no, customer_email, `language` FROM tbl_complaint_details WHERE complaint_id = '".$complaintId."'"));
    }
    function SaveComplaintStatus($loginId,$complaintId,$previousStatusId,$statusId,$user_id,$unitId,$source,$progress,$notes)
    {
        DB::table('tbl_complaint_status')->insert(
            [   'login_id' => $loginId, 
                'complaint_id' => $complaintId,
                'previous_state' => $previousStatusId,
                'current_state' => $statusId,
                'assign_to' => $unitId,
                'source' => $source,
                'progress' => $progress,
                'comments' => $notes
            ]
        );
    }
    public function ComplaintShow($complainId)
    {
        return DB::select(DB::raw("SELECT c.complaint_id, c.daily_counter, c.complaint_num,c.agent_id,c.group_id,c.unit_id,c.from_unit_id,c.user_id,c.product_category,c.product_id,
        c.complaint_type_id,c.priority_id,c.status_id,c.progress,c.file_counter,c.comments,c.comments_progress, c.is_approved,
        c.comments_verified,c.create_date,c.end_date,c.forward_date,c.close_date,us.user_name users,
        u.user_name agent_name, g.group_name group_fullname, d.`language`, c.favor, c.close_notes, c.amount,
        pr.priority,s.fullname complaint_status, c.source, pc.fullname product_category_name, tbl_product.fullname product_name, ct.fullname complaint_type, ct.tat complaint_type_tat, CONCAT(br.unit_name,' (', br.branch_code , ')') branch,
        d.compl_title,d.customer_name,d.cnic,d.mother_maiden,d.dob,d.account_no,d.complaint_nature,d.channel,d.description,d.callback_num,d.delivery_address,d.residence_address,
        d.is_email,d.customer_email,d.is_sms,d.response_number,d.is_call_back, d.customer_branch_id, d.against_branch_id, d.office_phone, cl.unit_name, cl.branch_code
        FROM tbl_complaints c
        LEFT JOIN tbl_complaint_details d ON d.complaint_id = c.complaint_id
        LEFT JOIN tbl_users u ON c.agent_id = u.id
        LEFT JOIN tbl_priority pr ON pr.id = c.priority_id
        LEFT JOIN tbl_status s ON c.status_id = s.id
        LEFT JOIN tbl_product_category pc ON pc.id = c.product_category
        LEFT JOIN tbl_product ON tbl_product.id = c.product_id
        INNER JOIN tbl_complaint_type ct ON c.complaint_type_id = ct.id
        LEFT JOIN tbl_groups g ON c.group_id = g.id
        LEFT JOIN tbl_users us ON us.id = c.user_id
        LEFT JOIN tbl_org_unit br ON br.id = d.customer_branch_id
        LEFT JOIN tbl_org_unit cl ON cl.id = c.from_unit_id
        WHERE c.complaint_id = '$complainId'"));
    }
    public function GetComplaintStatus($complaintId)
    {
        return DB::select(DB::raw("SELECT *, (SELECT user_name FROM `tbl_users` WHERE id IN (s.`login_id`)) AS activity_performer,
        p.fullname previous_state_name, c.fullname current_state_name
        FROM tbl_complaint_status s
        INNER JOIN tbl_status c ON c.id = s.current_state
        INNER JOIN tbl_status p ON p.id = s.previous_state
        WHERE complaint_id = '$complaintId' ORDER BY update_datetime DESC LIMIT 0,30"));
    }
    public function GetSaveSMSByComplaint($complaintId)
    {
        return DB::select(DB::raw("SELECT * FROM tbl_sms_comp_eform_save WHERE comp_eform_id = '$complaintId' AND type LIKE 'complaint%' ORDER BY id DESC LIMIT 50"));
    }
    public function GetSaveEscalationByComplaint($complaintId)
    {
        return DB::select(DB::raw("SELECT * FROM tbl_emails_comp_eform_save WHERE comp_eform_id = '$complaintId' AND type = 'complaint_escalation' ORDER BY template_subject DESC LIMIT 5"));
    }
    public function SetEmailEscalation($complaintId, $branchId)
    {

        $templateArray = array("1" => "13", "2" => "14", "3" => "15", "4" => "16");

        for($i = 1; $i <= 4; $i++) {

            $data= DB::select(DB::raw("SELECT escalation_time$i escalation_time,`level$i` escalation_group_id FROM tbl_escalation_branches
             WHERE branch_id = $branchId"));

            if(count($data) > 0){

                $escalationGroupId    = $data[0]->escalation_group_id;
                $escalationTime        = $data[0]->escalation_time;

                if(!empty($escalationTime)){

                    $objComplaintManagement = new ComplaintManagementController();
                    $escalationDate = $objComplaintManagement->GetWorkingDays(GetCurrentDate(),$escalationTime);

                    DB::table('tbl_escalation_execute')->insert(
                        [   'complaint_id' => $complaintId, 
                            'branch_id' => $branchId, 
                            'escalation_group_id' => $escalationGroupId, 
                            'template_id' => $templateArray[$i], 
                            'escalation_level' => 'Level'.' '.$i, 
                            'escalation_date' => $escalationDate, 
                            'created_datetime' => GetCurrentDateTime(), 
                        ]
                    );
                }

                //SaveEmailCompEform('complaint_escalation',$complaint_id,'13',$email_users['emails']);
            }
        }

        return "success";

    }
    public function getComplaintSMSDetails($request,$groupId)
    {
        $paginationEnv=env('PAGINATION');
        $complaintNum=$request->complaint_number;
        $fromDate=$request->from_date;
        $toDate=$request->to_date;
        $userId = Session::get('login_id');
        $unitId = Session::get('unit_id');
        $userType = Session::get('user_type');
        $dataSession=array('unit_id'=>$unitId,'agent_id'=>$userId,'user_type'=>$userType);
        $fromDate=str_replace(",","",$fromDate);
        $toDate=str_replace(",","",$toDate);
        $date=array('from_date'=>$fromDate,'to_date'=>$toDate);
        $complaint= DB::table('tbl_complaints AS c')
        ->join('tbl_sms_comp_eform_save AS sms', 'sms.comp_eform_id', '=', 'c.complaint_id')
        ->leftJoin('tbl_complaint_details AS d', 'd.complaint_id', '=', 'c.complaint_id')
        ->leftJoin('tbl_users AS u', 'c.agent_id', '=', 'u.id')
        ->leftJoin('tbl_status AS s', 'c.status_id', '=', 's.id')
        ->leftJoin('tbl_product_category AS pc', 'pc.id', '=', 'c.product_category')
        ->leftJoin('tbl_product AS pp', 'pp.id', '=', 'c.product_id')
        ->join('tbl_complaint_type AS ct', 'c.complaint_type_id', '=', 'ct.id')
        ->leftJoin('tbl_groups AS g', 'c.group_id', '=', 'g.id')
        ->leftJoin('tbl_users AS us', 'us.id', '=', 'c.user_id')
        ->leftJoin('tbl_org_unit AS br', 'br.id', '=', 'd.customer_branch_id')
        ->leftJoin('tbl_org_unit AS brass', 'brass.id', '=', 'c.unit_id')
        ->leftJoin('tbl_org_unit AS lodgeby', 'lodgeby.id', '=', 'c.from_unit_id')
        ->leftJoin('tbl_source AS sor', 'sor.id', '=', 'c.source')
        ->select(DB::raw("c.complaint_id, c.complaint_num, CONCAT(br.unit_name,' (', br.branch_code , ')') customer_branch, c.create_date, c.close_date, d.compl_title, d.customer_name, d.cnic, sor.source_name,
        CONCAT(lodgeby.unit_name,' (', lodgeby.branch_code , ')') lodge_by, d.description, pc.fullname product_category_name, pp.fullname product_name, ct.fullname complaint_type,
        c.status_id, s.fullname complaint_status, c.end_date, g.group_name group_fullname, CONCAT(brass.unit_name,' (', brass.branch_code , ')') assign_branch,
        (SELECT CONCAT(`datetime`,'|',sms) FROM tbl_sms_comp_eform_save WHERE `type` = 'complaint_initiated' AND tbl_sms_comp_eform_save.comp_eform_id = c.complaint_id ORDER BY tbl_sms_comp_eform_save.`datetime` DESC LIMIT 1) complaint_initiated,
        (SELECT CONCAT(`datetime`,'|',sms) FROM tbl_sms_comp_eform_save WHERE `type` = 'complaint_interim' AND tbl_sms_comp_eform_save.comp_eform_id = c.complaint_id ORDER BY tbl_sms_comp_eform_save.`datetime` DESC LIMIT 1) complaint_interim,
        (SELECT CONCAT(`datetime`,'|',sms) FROM tbl_sms_comp_eform_save WHERE `type` = 'complaint_closed' AND tbl_sms_comp_eform_save.comp_eform_id = c.complaint_id ORDER BY tbl_sms_comp_eform_save.`datetime` DESC LIMIT 1) complaint_closed"))
        ->when($dataSession, function ($query, $dataSession) {
            if($dataSession['user_type'] != 1 && $dataSession['user_type'] != 2)
            {
                $unitId=$dataSession['unit_id'];
                $userId=$dataSession['agent_id'];
                return $query->whereRaw("AND c.unit_id IN ($unitId) OR c.from_unit_id IN ($unitId) OR c.agent_id = '$userId'");
            }
          })
        ->when($date, function ($query, $date) {
            if($date['from_date'] != '' && $date['to_date'] != '')
            {
                $fromDate=date("Y-m-d",strtotime($date['from_date']));
                $toDate=date("Y-m-d",strtotime($date['to_date']));
                return $query->whereRaw("DATE(c.create_date) BETWEEN '$fromDate' AND '$toDate'");
            }
        })
        ->when($complaintNum, function ($query, $complaintNum) {
          return $query->where('c.complaint_num', $complaintNum);
        })
        ->when($groupId, function ($query, $groupId) {
            return $query->groupBy('c.complaint_id');
          })
        ->orderBy('c.create_date', 'desc')->paginate($paginationEnv);
        $complaint->appends(['complaint_number' => $complaintNum,'from_date'=>$fromDate,'to_date'=>$toDate]);
        return $complaint;
    }
    public  function getComplaintByTAT($request)
    {
        $queryPart='';
        if($request->status == 1)
        {
            if($request->from_date != '' && $request->to_date != '' )
            {
                $fromDate=str_replace(",","",$request->from_date);
                $toDate=str_replace(",","",$request->to_date);
                $fromDate=date("Y-m-d",strtotime($fromDate));
                $toDate=date("Y-m-d",strtotime($toDate));
                $queryPart = " AND DATE(create_date) BETWEEN '$fromDate' AND '$toDate'";
            }
            $queryStatus = "AND status_id IN (1,2,5)";

            $result= DB::select(DB::raw("SELECT
            (SELECT COUNT(1) FROM tbl_complaints WHERE 1=1 $queryStatus $queryPart) AS total,
            (SELECT COUNT(1) FROM tbl_complaints WHERE DATE(NOW()) <= DATE(end_date) $queryStatus $queryPart) AS within_tat,
            (SELECT COUNT(1) FROM tbl_complaints WHERE DATE(NOW()) > DATE(end_date) $queryStatus $queryPart) AS beyond_tat"));
            return $result;
        }
        else
        {
            if($request->from_date != '' && $request->to_date != '' )
            {
                $fromDate=str_replace(",","",$request->from_date);
                $toDate=str_replace(",","",$request->to_date);
                $fromDate=date("Y-m-d",strtotime($fromDate));
                $toDate=date("Y-m-d",strtotime($toDate));
                $queryPart = " AND DATE(close_date) BETWEEN '$fromDate' AND '$toDate'";
            }
            $queryStatus = "AND status_id IN (3)";
            $result= DB::select(DB::raw("SELECT
            (SELECT COUNT(1) FROM tbl_complaints WHERE 1=1 $queryPart) AS total,
            (SELECT COUNT(1) FROM tbl_complaints WHERE DATE(NOW()) <= DATE(end_date) $queryStatus $queryPart) AS within_tat,
            (SELECT COUNT(1) FROM tbl_complaints WHERE DATE(NOW()) > DATE(end_date) $queryStatus $queryPart) AS beyond_tat"));
            return $result;
        }
    }
    public function getComplaintStatusReport($request)
    {
        $queryPart='';
        if($request->from_date != '' && $request->to_date != '' )
        {
            $fromDate=str_replace(",","",$request->from_date);
            $toDate=str_replace(",","",$request->to_date);
            $fromDate=date("Y-m-d",strtotime($fromDate));
            $toDate=date("Y-m-d",strtotime($toDate));
            $queryPart = "AND DATE(create_date) BETWEEN '$fromDate' AND '$toDate'";
        }
        $result= DB::select(DB::raw("SELECT
        (SELECT COUNT(1) FROM tbl_complaints WHERE 1=1 $queryPart) AS total_complaints,
        (SELECT COUNT(1) FROM tbl_complaints WHERE status_id = 1 $queryPart) AS initiated,
        (SELECT COUNT(1) FROM tbl_complaints WHERE status_id = 2 $queryPart) AS in_progress,
        (SELECT COUNT(1) FROM tbl_complaints WHERE status_id = 3 $queryPart) AS closed,
        (SELECT COUNT(1) FROM tbl_complaints WHERE status_id = 4 $queryPart) AS verified,
        (SELECT COUNT(1) FROM tbl_complaints WHERE status_id = 5 $queryPart) AS invalid,
        (SELECT COUNT(1) FROM tbl_complaints WHERE status_id = 6 $queryPart) AS onhold"));
        return $result;
    }
    public function getSmsInterimReport($request,$groupId)
    {
        $paginationEnv=env('PAGINATION');
        $complaintNum=$request->complaint_number;
        $fromDate=$request->from_date;
        $toDate=$request->to_date;
        $userId = Session::get('login_id');
        $unitId = Session::get('unit_id');
        $userType = Session::get('user_type');
        $dataSession=array('unit_id'=>$unitId,'agent_id'=>$userId,'user_type'=>$userType);
        $fromDate=str_replace(",","",$fromDate);
        $toDate=str_replace(",","",$toDate);
        $date=array('from_date'=>$fromDate,'to_date'=>$toDate);
        $complaint= DB::table('tbl_complaints AS c')
        ->join('tbl_sms_interim AS sms', 'sms.complaint_id', '=', 'c.complaint_id')
        ->leftJoin('tbl_complaint_details AS d', 'd.complaint_id', '=', 'c.complaint_id')
        ->leftJoin('tbl_users AS u', 'c.agent_id', '=', 'u.id')
        ->leftJoin('tbl_status AS s', 'c.status_id', '=', 's.id')
        ->leftJoin('tbl_product_category AS pc', 'pc.id', '=', 'c.product_category')
        ->leftJoin('tbl_product AS pp', 'pp.id', '=', 'c.product_id')
        ->join('tbl_complaint_type AS ct', 'c.complaint_type_id', '=', 'ct.id')
        ->leftJoin('tbl_groups AS g', 'c.group_id', '=', 'g.id')
        ->leftJoin('tbl_users AS us', 'us.id', '=', 'c.user_id')
        ->leftJoin('tbl_org_unit AS br', 'br.id', '=', 'd.customer_branch_id')
        ->leftJoin('tbl_org_unit AS brass', 'brass.id', '=', 'c.unit_id')
        ->leftJoin('tbl_org_unit AS lodgeby', 'lodgeby.id', '=', 'c.from_unit_id')
        ->leftJoin('tbl_source AS sor', 'sor.id', '=', 'c.source')
        ->select(DB::raw("c.complaint_id, c.complaint_num, CONCAT(br.unit_name,' (', br.branch_code , ')') customer_branch, c.create_date, c.end_date, c.close_date, d.compl_title, d.customer_name, d.cnic, sor.source_name,
        CONCAT(lodgeby.unit_name,' (', lodgeby.branch_code , ')') lodge_by, d.description, pc.fullname product_category_name, pp.fullname product_name, ct.fullname complaint_type,
        c.status_id, s.fullname complaint_status, g.group_name group_fullname, CONCAT(brass.unit_name,' (', brass.branch_code , ')') assign_branch"))
        ->when($dataSession, function ($query, $dataSession) {
            if($dataSession['user_type'] != 1 && $dataSession['user_type'] != 2)
            {
                $unitId=$dataSession['unit_id'];
                $userId=$dataSession['agent_id'];
                return $query->whereRaw("AND c.unit_id IN ($unitId) OR c.from_unit_id IN ($unitId) OR c.agent_id = '$userId'");
            }
          })
        ->when($date, function ($query, $date) {
            if($date['from_date'] != '' && $date['to_date'] != '')
            {
                $fromDate=date("Y-m-d",strtotime($date['from_date']));
                $toDate=date("Y-m-d",strtotime($date['to_date']));
                return $query->whereRaw("DATE(sms.interim_date) BETWEEN '$fromDate' AND '$toDate'");
            }
        })
        ->when($complaintNum, function ($query, $complaintNum) {
          return $query->where('c.complaint_num', $complaintNum);
        })
        ->when($groupId, function ($query, $groupId) {
            return $query->groupBy('c.complaint_id');
          })
        ->orderBy('c.complaint_id', 'desc')->paginate($paginationEnv);
        $complaint->appends(['complaint_number' => $complaintNum,'from_date'=>$fromDate,'to_date'=>$toDate]);
        return $complaint;
    }
}
