<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Announcement;

class DashboardController extends Controller
{
    public function index()
    {
        $unitId = Session::get('unit_id');
        $userType = Session::get('user_type');
        $loginId = Session::get('login_id');
        $news=Announcement::where('type','news')->where('is_active','1')->where('forward_to_user_type',$userType)->orderby('id','desc')->get();
        $message=Announcement::where('type','message')->where('is_active','1')->whereRaw("FIND_IN_SET('$loginId', forward_to_user)")->orderby('id','desc')->get();
        $allComplaints='';
        $allEforms='';
        $agentActivityLogs=DB::table('tbl_logs_activity_agent')->select(DB::raw('call_id,agent_id,description,action_on,created_datetime'))->where('call_id','!=','')
        ->when($userType != "1", function ($query) use ($loginId) {
            return $query->where("login_id",$loginId);
        })->orderBy('id', 'desc')->limit(10)->get();
        if ($userType == 1 || $userType == 3) {
           $result= DB::select(DB::raw("SELECT
            (SELECT COUNT(1) FROM tbl_complaints c INNER JOIN tbl_complaint_type t ON t.id = c.complaint_type_id) AS total_complaints,
            (SELECT COUNT(1) FROM tbl_complaints c INNER JOIN tbl_complaint_type t ON t.id = c.complaint_type_id WHERE status_id = 3) AS closed_complaints,
            (SELECT COUNT(1) FROM tbl_eform_add e INNER JOIN tbl_eform_type t ON t.id = e.eform_type_id) AS total_eforms,
            (SELECT COUNT(1) FROM tbl_eform_add e INNER JOIN tbl_eform_type t ON t.id = e.eform_type_id WHERE e.status_id = 3) AS closed_eforms"));
        }
        elseif($userType == 2){
            $result= DB::select(DB::raw("SELECT
            (SELECT COUNT(1) FROM tbl_complaints c INNER JOIN tbl_complaint_type t ON t.id = c.complaint_type_id) AS total_complaints,
            (SELECT COUNT(1) FROM tbl_complaints c INNER JOIN tbl_complaint_type t ON t.id = c.complaint_type_id WHERE status_id = 3) AS closed_complaints,
            (SELECT COUNT(1) FROM tbl_eform_add e WHERE e.unit_id IN ($unitId) OR e.from_unit_id IN ($unitId)) AS total_eforms,
            (SELECT COUNT(1) FROM tbl_eform_add e WHERE e.status_id = 3 AND (e.unit_id IN ($unitId) OR e.from_unit_id IN ($unitId))) AS closed_eforms"));
        }
        elseif($userType == 5){

            if($allComplaints == 1){
                $queryPartAllComplaints44 = "(SELECT COUNT(1) FROM tbl_complaints c INNER JOIN tbl_complaint_type t ON t.id = c.complaint_type_id) AS total_complaints,
					                            (SELECT COUNT(1) FROM tbl_complaints c INNER JOIN tbl_complaint_type t ON t.id = c.complaint_type_id WHERE status_id = 3) AS closed_complaints,";
            }else{
                $queryPartAllComplaints44 = "(SELECT COUNT(1) FROM tbl_complaints c WHERE c.unit_id IN ($unitId) OR c.from_unit_id IN ($unitId)) AS total_complaints,
                                                (SELECT COUNT(1) FROM tbl_complaints c WHERE c.status_id = 3 AND c.unit_id IN ($unitId) OR c.from_unit_id IN ($unitId)) AS closed_complaints,";
            }


            if($allEforms == 1){
                $queryPartAllEform44 = "(SELECT COUNT(1) FROM tbl_eform_add e WHERE 1=1) AS total_eforms,
                                           (SELECT COUNT(1) FROM tbl_eform_add e WHERE e.status_id = 3) AS closed_eforms;";
            }else{
                $queryPartAllEform44 = "(SELECT COUNT(1) FROM tbl_eform_add e WHERE e.unit_id IN ($unitId) OR e.from_unit_id IN ($unitId)) AS total_eforms,
                                           (SELECT COUNT(1) FROM tbl_eform_add e WHERE e.status_id = 3 AND e.unit_id IN ($unitId) OR e.from_unit_id IN ($unitId)) AS closed_eforms;";
            }

            if($unitId != 44){
                $result= DB::select(DB::raw("SELECT $queryPartAllComplaints44 $queryPartAllEform44"));

            }else{

                if($allComplaints == 1){
                    $queryPartAllComplaints = "(SELECT COUNT(1) FROM tbl_complaints c INNER JOIN tbl_complaint_type t ON t.id = c.complaint_type_id) AS total_complaints,
					                              (SELECT COUNT(1) FROM tbl_complaints c INNER JOIN tbl_complaint_type t ON t.id = c.complaint_type_id WHERE status_id = 3) AS closed_complaints,";
                }else{
                    $queryPartAllComplaints = "(SELECT COUNT(1) FROM tbl_complaints c WHERE c.unit_id IN ($unitId) OR c.from_unit_id IN ($unitId)) AS total_complaints,
                                                  (SELECT COUNT(1) FROM tbl_complaints c WHERE c.status_id = 3 AND c.unit_id IN ($unitId) OR c.from_unit_id IN ($unitId)) AS closed_complaints,";
                }


                if($allEforms == 1){
                    $queryPartAllEform = "(SELECT COUNT(1) FROM tbl_eform_add e WHERE 1=1) AS total_eforms,
                                             (SELECT COUNT(1) FROM tbl_eform_add e WHERE e.status_id = 3) AS closed_eforms;";
                }else{
                    $queryPartAllEform = "(SELECT COUNT(1) FROM tbl_eform_add e WHERE 1=1) AS total_eforms,
                                             (SELECT COUNT(1) FROM tbl_eform_add e WHERE e.status_id = 3) AS closed_eforms;";
                }
                $result= DB::select(DB::raw("SELECT $queryPartAllComplaints $queryPartAllEform"));

            }
        }

        elseif($userType == 4){


            if($allComplaints == 1){
                $queryPartAllComplaints = "(SELECT COUNT(1) FROM tbl_complaints c INNER JOIN tbl_complaint_type t ON t.id = c.complaint_type_id) AS total_complaints,
					                          (SELECT COUNT(1) FROM tbl_complaints c INNER JOIN tbl_complaint_type t ON t.id = c.complaint_type_id WHERE status_id = 3) AS closed_complaints,";
            }else{
                $query_part_all_complaints = "(SELECT COUNT(1) FROM tbl_complaints c WHERE c.unit_id IN ($unitId) OR c.from_unit_id IN ($unitId)) AS total_complaints,
                                              (SELECT COUNT(1) FROM tbl_complaints c WHERE c.status_id = 3 AND c.unit_id IN ($unitId) OR c.from_unit_id IN ($unitId)) AS closed_complaints,";
            }


            if($allEforms == 1){
                $queryPartAllEform = "(SELECT COUNT(1) FROM tbl_eform_add e WHERE 1=1) AS total_eforms,
                                         (SELECT COUNT(1) FROM tbl_eform_add e WHERE e.status_id = 3) AS closed_eforms;";
            }else{
                $queryPartAllEform = "(SELECT COUNT(1) FROM tbl_eform_add e WHERE e.unit_id IN ($unitId) OR e.from_unit_id IN ($unitId)) AS total_eforms,
                                         (SELECT COUNT(1) FROM tbl_eform_add e WHERE e.status_id = 3 AND (e.unit_id IN ($unitId) OR e.from_unit_id IN ($unitId))) AS closed_eforms;";
            }
            $result= DB::select(DB::raw("SELECT $queryPartAllComplaints $queryPartAllEform"));


        }

        else{
            $result= DB::select(DB::raw("SELECT
            (SELECT COUNT(1) FROM tbl_complaints c WHERE c.unit_id IN ($unitId) OR c.from_unit_id IN ($unitId)) AS total_complaints,
            (SELECT COUNT(1) FROM tbl_complaints c WHERE c.status_id = 3 AND c.unit_id IN ($unitId) OR c.from_unit_id IN ($unitId)) AS closed_complaints,
            (SELECT COUNT(1) FROM tbl_eform_add e WHERE e.unit_id IN ($unitId) OR e.from_unit_id IN ($unitId)) AS total_eforms,
            (SELECT COUNT(1) FROM tbl_eform_add e WHERE e.status_id = 3 AND e.unit_id IN ($unitId) OR e.from_unit_id IN ($unitId)) AS closed_eforms"));
        }
        $sidebarMenu=Session::get('sidebar_menu');
        dd($sidebarMenu);

        return view('dashboard',compact('message','news','agentActivityLogs','result'));
    }
}
