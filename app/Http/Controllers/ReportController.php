<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
}
