<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\ComplaintManagement;
use App\Models\EFormManagement;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
    public function agentActivity(Request $request)
    {
        $paginationEnv=env('PAGINATION');
        $agents=User::select('id','user_name')->where('isactive','1')->where('user_type','3')->get();
        $activities=DB::table('tbl_activity_names')->get();

        $data=DB::table('tbl_logs_activity_agent')
        ->when($request->agent, function ($query, $search) {
            return $query->where('login_id', $search);
        })
        ->when($request->activity_name, function ($query, $search) {
            if($search != 'All Activity')
            {
                return $query->where('description', $search);
            }
        })
        ->when($request->cnic_mobile_account, function ($query, $search) {
                return $query->where('action_on', $search);
        })
        ->when(['from'=>$request->from_date,'to'=>$request->to_date], function ($query,$search) {
            if($search['from'] != null && $search['to'] != null)
            {
                $from=Date("Y-m-d",strtotime(str_replace(",","",$search['from'])));
                $to=Date("Y-m-d",strtotime(str_replace(",","",$search['to'])));
                return $query->whereBetween('created_datetime', [$from, $to]);
            }
                
        })
        ->paginate($paginationEnv);
        $data->appends(['agent' => $request->agent,'activity_name'=>$request->activity_name,
        'cnic_mobile_account'=>$request->cnic_mobile_account,'from_date'=>$request->from_date,
        'to_date'=>$request->to_date]);
        return view('admin/report/report_agent_activity_logs',compact('data','agents','activities'));
    }
    public function sessionHistory(Request $request)
    {
        $paginationEnv=env('PAGINATION');
        $data=DB::table('tbl_logs_session')
        ->when($request->search, function ($query, $search) {
            return  $query->whereRaw("CONCAT(user_name,user_agent,user_ip) like '%$search%'");
        })->paginate($paginationEnv);
        return view('admin/report/report_session_history_logs',compact('data'));
    }
    public function transaction(Request $request)
    {
        $paginationEnv=env('PAGINATION');
        $data=DB::table('tbl_logs_transaction AS a')
        ->join('tbl_users_type AS t', 'a.user_type', '=', 't.id')
        ->leftJoin('tbl_request_reasons AS r', 'r.id', '=', 'a.reason_id')
        ->SelectRaw("a.*,t.fullname user_type_name,
        CASE
          WHEN a.reason_id = '-99' 
          THEN 'Other' 
          ELSE r.fullname 
        END AS reason")
        ->when($request->search, function ($query, $search) {
            return  $query->whereRaw("CONCAT(t.fullname) like '%$search%'");
        })->paginate($paginationEnv);


    //   $statusArray = array(
    //     "00" => "Active",
    //     "01" => "InActive",
    //     "02" => "Block",
    //     "Y" => "Active",
    //     "N" => "InActive"
    // );
        return view('admin/report/report_transaction_logs',compact('data'));
    }
    public function complaints(Request $request)
    {
        $objComplaintManagement = new ComplaintManagement();
        $complaint=$objComplaintManagement->getComplaint($request);
        return view('admin/report/report_complaints',compact('complaint'));
    }
    public function escalation(Request $request)
    {
        $objComplaintManagement = new ComplaintManagement();
        $complaint=$objComplaintManagement->getComplaintEscalation($request);
        return view('admin/report/report_escalation',compact('complaint'));
    }
    public  function complaintTat(Request $request)
    {
        $objComplaintManagement = new ComplaintManagement();
        $companintTat=$objComplaintManagement->getComplaintByTAT($request);
        return view('admin/report/report_complaint_tat',compact('companintTat'));
    }
    public function complaintStatus(Request $request)
    {
        $objComplaintManagement = new ComplaintManagement();
        $complaintStatus=$objComplaintManagement->getComplaintStatusReport($request);
        return view('admin/report/report_complaint_status',compact('complaintStatus'));
    }
    public  function smsDetails(Request $request)
    {
        $objComplaintManagement = new ComplaintManagement();
        $groupId='1';
        $complaint=array();
        if($request->complaint_number != '' || $request->from_date != '' || $request->to_date != '')
        {
            $complaint=$objComplaintManagement->getComplaintSMSDetails($request,$groupId);
        }
        return view('admin/report/report_sms_details',compact('complaint'));
    }
    public function smsInterim(Request $request)
    {
        $groupId=1;
        $objComplaintManagement = new ComplaintManagement();
        $complaint=$objComplaintManagement->getSmsInterimReport($request,$groupId);
        return view('admin/report/report_sms_interim',compact('complaint'));
    }
    public function sendEmails(Request $request)
    {
        $search=$request->search;
        $paginationEnv=env('PAGINATION');
        $data=DB::table('tbl_emails_comp_eform_save')
        ->when($search, function ($query, $search) {
            return $query->where('comp_eform_number', $search);
          })
        ->orderBy('id','DESC')->paginate($paginationEnv);;
        return view('admin/report/report_send_emails',compact('data'));
    }
    public function eForm(Request $request)
    {
        $objEFormManagement = new EFormManagement();
        $eForm=$objEFormManagement->getAllEForm($request);
        $userType = Session::get('user_type');
        $loginId = Session::get('login_id');
        return view('admin/report/report_eforms',compact('eForm','userType','loginId'));
    }
}
