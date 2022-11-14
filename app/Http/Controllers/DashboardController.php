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
        $news=Announcement::where('type','news')->where('is_active','1')->orderby('id','desc')->get();
        $message=Announcement::where('type','message')->where('is_active','1')->orderby('id','desc')->get();
        $userType = Session::get('user_type');
        $loginId = Session::get('login_id');
        $agentActivityLogs=DB::table('tbl_logs_activity_agent')->select(DB::raw('call_id,agent_id,description,action_on,created_datetime'))
        ->when($userType != "1", function ($query) use ($loginId) {
            return $query->where("login_id",$loginId);
        })->orderBy('id', 'desc')->limit(10)->get();
        return view('dashboard',compact('message','news','agentActivityLogs'));

    }
}
