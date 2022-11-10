<?php

namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

trait Logs {

    public function ActivityLogs($description){
		$is_activity_logs=env('iS_ACTIVITY_LOGS');

		
		if($is_activity_logs == "1"){
			
			$datetime = GetCurrentDate();
			$loginId = Session::get('login_id');
			$userName = Session::get('user_name');
			$userType = Session::get('user_type');
            $userIp = \Request::ip();
            DB::insert('insert into tbl_logs_activity (description, created_datetime,login_id,user_type,user_name,user_ip) 
            values (?, ?,?,?,?,?)', [$description, $datetime , $loginId,$userType,$userName,$userIp]);
		}
			
	}
    public function SessionLoginLogs($login_id, $user_name, $user_agent, $user_ip){
		$is_session_logs=env('IS_SESSION_LOGS');
		if($is_session_logs == "1"){
			$datetime = GetCurrentDate();
            return DB::insert('insert into tbl_logs_session (login_id, user_name,user_agent,user_ip,login_datetime) 
            values (?, ?,?,?,?)', [$login_id, $user_name , $user_agent,$user_ip,$datetime]);
		}else{
			return true;
		}
		
	}
	public function ActivityAgentLogs($description, $actionOn, $transactionName, $responseStatus='', $rrn='', $caution='', $reasonId='0'){

		$is_agent_activity_logs=env('IS_AGENT_AVTIVITY_LOGS');

        if($reasonId <> ''){
			
            if($is_agent_activity_logs == "1"){

                $dateTime = GetCurrentDateTime();
				$callId = Session::get('call_id');
				$agentId = Session::get('user_id');
				$loginId = Session::get('login_id');
				$cnic = Session::get('nic');
				return DB::insert('insert into tbl_logs_activity_agent (call_id, agent_id, login_id, description, action_on, cnic, transaction_name, rrn, reason_id, caution, response_status, created_datetime) 
            values (?,?,?,?,?,?,?,?,?,?,?,?)', [$callId, $agentId , $loginId,$description,$actionOn,$cnic,$transactionName,$rrn,$reasonId,$caution,$responseStatus,$dateTime]);

            }else{
                return true;
            }

        }else{
            return true;
        }

    }

}