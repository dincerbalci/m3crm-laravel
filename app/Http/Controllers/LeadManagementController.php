<?php

namespace App\Http\Controllers;

use App\Models\LeadManagement;
use App\Models\User;
use App\Models\Group;
use App\Models\LeadNote;
use App\Http\Requests\LeadManagementRequest;
use App\Models\LeadFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\LeadCategory;
use App\Models\LeadFollowUp;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;

class LeadManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $loginId = Session::get('login_id');
        $userType = Session::get('user_type');
        $category=LeadCategory::get();
        $user=User::get();
        $paginationEnv=env('PAGINATION');
        $lead=LeadManagement::query();
        $lead->when($userType != '1', function ($query) use ($loginId) {
            $query->join('tbl_users AS ucb', 'ucb.id', '=', 'tbl_lead.user_id');
            $query->selectRaw('ucb.first_name AS cb_first_name,ucb.last_name AS cb_last_name, 
            tbl_lead.id, tbl_lead.salutation, tbl_lead.lead_name, tbl_lead.lead_source, tbl_lead.cnic, tbl_lead.email, tbl_lead.gender, tbl_lead.lead_value, tbl_lead.status, tbl_lead.created_at,
            (SELECT next_follow_up FROM `tbl_lead_follow_ups` where lead_id=tbl_lead.id ORDER BY next_follow_up ASC LIMIT 1) AS next_follow_up');
            $query->where('assigned_to',$loginId);
            return $query;
        });
        $lead->when($userType == '1', function ($query) use ($loginId) {
            $query->join('tbl_users AS ucb', 'ucb.id', '=', 'tbl_lead.user_id');
            $query->join('tbl_users AS uat', 'uat.id', '=', 'tbl_lead.assigned_to');
            $query->selectRaw('ucb.first_name AS cb_first_name,ucb.last_name AS cb_last_name,uat.first_name AS at_first_name,uat.last_name AS at_last_name,
            tbl_lead.id,tbl_lead.salutation,tbl_lead.lead_name,tbl_lead.lead_source,tbl_lead.cnic,tbl_lead.email,tbl_lead.gender,tbl_lead.lead_value,tbl_lead.status,tbl_lead.created_at,
            (SELECT next_follow_up FROM `tbl_lead_follow_ups` where lead_id=tbl_lead.id ORDER BY next_follow_up ASC LIMIT 1) AS next_follow_up');
            return $query;
        });
        $lead->when($request->cnic, function ($query, $cnic) {
            return $query->where('tbl_lead.cnic', $cnic);
          });
        $lead->when($request->lead_category, function ($query, $leadCategory) {
            return $query->where('tbl_lead.lead_category_id', $leadCategory);
        });
        $lead->when($request->assigned_to, function ($query, $assignedTo) {
            return $query->where('tbl_lead.assigned_to', $assignedTo);
        });
        $lead->when($request->status, function ($query, $status) {
            return $query->where('tbl_lead.status', $status);
        });
        $lead = $lead->orderby('tbl_lead.id','DESC')->paginate($paginationEnv);
        $lead->appends(['cnic' => $request->cnic,'lead_category_id'=>$request->lead_category,
                        'assigned_to'=>$request->assigned_to,'status'=>$request->status]);
        return view('admin/lead/lead_index',compact('category','user','userType','lead'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $loginId = Session::get('login_id');
       $userType = Session::get('user_type');
       $category=LeadCategory::get();
    //    $user=User::where('id','!=',$loginId)->get();
       $group=Group::whereIn('id', [4, 5, 6])->get();
        return view('admin/lead/lead_create',compact('category','group','userType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeadManagementRequest $request)
    {
       $loginId = Session::get('login_id');
       $groupIds = Session::get('group_id');
        $assignedTo=$request->assigned_to;
        $groupId=$request->group_id;
        if($request->assigned_to == '0')
        {
            $assignedTo=$loginId;
            $groupId=$groupIds;
        }
        $data = LeadManagement::create([
            'salutation' => $request->salutation,
            'user_id' => $loginId,
            'assigned_to' => $assignedTo,
            'group_id' => $groupId,
            'lead_name' => $request->lead_name,
            'cnic' => $request->cnic,
            'email' => $request->email,
            'gender' => $request->gender,
            'office_phone_number' => $request->office_phone_number,
            'lead_source' => $request->lead_source,
            'lead_value' => $request->lead_value,
            'allow_follow_up' => $request->allow_follow_up,
            'status' => $request->status,
            'lead_category_id' => $request->lead_category,
            'description' => $request->description,
            'company_name' => $request->company_name,
            'website' => $request->website,
            'state' => $request->state,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
        ]);
        session()->flash('message', 'Successfully Saved!');
        session()->flash('alert-type', 'success');
            //$request->session()->flash('message', 'Email Does Not Exists');

        return $this->redirect();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeadManagement  $leadManagement
     * @return \Illuminate\Http\Response
     */
    public function show(LeadManagement $lead)
    {
        $loginId = Session::get('login_id');
        $userType = Session::get('user_type');
        $category=LeadCategory::get();
        $group=Group::whereIn('id', [4, 5, 6])->get();
        $leadNote=LeadNote::where('lead_id',$lead->id)->orderBy('id', 'desc')->get();
        $leadFile=LeadFile::where('lead_id',$lead->id)->orderBy('id', 'desc')->get();
        $leadFollowUp=LeadFollowUp::where('lead_id',$lead->id)->orderBy('next_follow_up', 'ASC')->get();
        return view('admin/lead/lead_show',compact('category','group','lead','leadNote','leadFile','leadFollowUp','userType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeadManagement  $leadManagement
     * @return \Illuminate\Http\Response
     */
    public function edit(LeadManagement $lead)
    {
        $loginId = Session::get('login_id');
        $userType = Session::get('user_type');
        $category=LeadCategory::get();
        // $user=User::where('id','!=',$loginId)->get();
        $group=Group::whereIn('id', [4, 5, 6])->get();
        return view('admin/lead/lead_edit',compact('category','group','lead','userType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeadManagement  $leadManagement
     * @return \Illuminate\Http\Response
     */
    public function update(LeadManagementRequest $request, LeadManagement $lead)
    {
        $loginId = Session::get('login_id');
       $groupIds = Session::get('group_id');
        $assignedTo=$request->assigned_to;
        $groupId=$request->group_id;
        if($request->assigned_to == '0')
        {
            $assignedTo=$loginId;
            $groupId=$groupIds;
        }
        $lead->salutation =   $request->salutation;
        $lead->user_id =      $loginId;
        $lead->assigned_to =  $assignedTo;
        $lead->group_id =  $groupId;
        $lead->lead_name =    $request->lead_name;
        $lead->cnic =         $request->cnic;
        $lead->email =        $request->email;
        $lead->gender =       $request->gender;
        $lead->office_phone_number = $request->office_phone_number;
        $lead->lead_source =  $request->lead_source;
        $lead->lead_value =   $request->lead_value;
        $lead->allow_follow_up = $request->allow_follow_up;
        $lead->status =       $request->status;
        $lead->lead_category_id = $request->lead_category;
        $lead->description =  $request->description;
        $lead->company_name = $request->company_name;
        $lead->website =      $request->website;
        $lead->state =        $request->state;
        $lead->city =         $request->city;
        $lead->postal_code =  $request->postal_code;
        $lead->address =      $request->address;
        $lead->save();

        session()->flash('message', 'Successfully Updated!');
        session()->flash('alert-type', 'success');
        return $this->redirect();
    }
    public function leadDelete(Request $request)
    {
        $id=$request->id;
        return view('admin/lead/lead_delete',compact('id'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeadManagement  $leadManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeadManagement $lead)
    {
        LeadNote::where('lead_id',$lead->id)->delete();
        $leadFile=LeadFile::where('lead_id',$lead->id)->get();
        if(count($leadFile) > 0)
        {
            File::delete($leadFile->path);
            $leadFile->delete();    
        }
        LeadFollowUp::where('lead_id',$lead->id)->delete();
        $lead->delete();
        session()->flash('message', 'Successfully Deleted!');
        session()->flash('alert-type', 'success');
        return redirect()->back();
    }
    private function redirect()
    {
        return redirect()->route('lead.index');

    }
    public function leadUser(Request $request)
    {
        $groupId=$request->group_id;
        $user=User::select('id','first_name','last_name')->where('group_id',$groupId)->where('isactive','1')->get();
        return $user;
    }
}
