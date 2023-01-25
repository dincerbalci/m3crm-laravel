<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Unit;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $objUser= new User();
        $group=Group::where('isactive','1')->where('id','!=','1')->get();
        $unit=Unit::get();
        $user=$objUser->GetUsers($request);
        return view('admin/administration/user_index',compact('user','group','unit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $group=Group::where('isactive','1')->where('id','!=','1')->get();
        $role=Role::where('isactive','1')->orderby('id','desc')->get();
        return view('admin/administration/user_create',compact('group','role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        
        if($request->unit_id == "0"){
            $units =Unit::where('region_id',$request->region_id)->select(DB::raw('GROUP_CONCAT(id) as unit_id'))->get();
            $unitId = $units[0]->unit_id;
        }
        else
        {
            $unitId=$request->unit_id;
        }

        if($request->isadmin == "1"){
            $userType = "1"; $groupId = "0"; $unitId = "0"; $roleId = "0";
        }
        else
        {
            $userType=$request->group_id;$groupId=$request->group_id;$unitId=$request->unit_id;$roleId=$request->role_id;
        }

        $data = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'user_type' => $userType,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'employee_id' => $request->employee_id,
            'mobile_no'=>$request->mobile_no,
            'region_id'=>$request->region_id,
            'unit_id'=>$unitId,
            'group_id'=>$groupId,
            'role_id'=>$roleId,
            'isactive'=>$request->isactive,
            'isadmin'=>$request->isadmin,
            'expiry_date'=>DATE('Y-m-d',strtotime('+1 month')),
            'last_login'=>'0000-00-00 00:00:00',
            'is_all_complaint'=>$request->is_all_complaint,
            'is_all_eform'=>$request->is_all_eform,
            'create_datetime'=> GetCurrentDateTime(),
        ]);
        $this->ActivityLogs("Add User [LoginId:$data->id, UserId:$request->user_name, Email:$request->email, User Type:$userType]");
        if($request->isadmin != "1"){
            if(!empty($data->id) && !empty($roleId)){
                $role=Role::select(DB::raw('GROUP_CONCAT(primary_name) as role_name'))->where('id',$roleId)->get();
                $roleName = $role[0]->role_name;
                $this->ActivityLogs("Add Role to User [LoginId: $data->id, UserId: $request->user_name, Roles Assign: $roleName]");
                DB::table('tbl_users_role')->insert(['user_id'=> $data->id,'role_id'=>$roleId]);
            }
        }
        session()->flash('message', 'Successfully Saved!');
        session()->flash('alert-type', 'success');
       return $this->redirect();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group=Group::where('isactive','1')->where('id','!=','1')->get();
        $role=Role::where('isactive','1')->orderby('id','desc')->get();
        $user=User::find($id);
        return view('admin/administration/user_edit',compact('group','role','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user=User::find($id);
        if($request->unit_id == "0"){
            $units =Unit::where('region_id',$request->region_id)->select(DB::raw('GROUP_CONCAT(id) as unit_id'))->get();
            $unitId = $units[0]->unit_id;
        }
        else
        {
            $unitId=$request->unit_id;
        }

        if($request->isadmin == "1"){
            $userType = "1"; $groupId = "0"; $unitId = "0"; $roleId = "0";
        }
        else
        {
            $userType=$request->group_id;$groupId=$request->group_id;$unitId=$request->unit_id;$roleId=$request->role_id;
        }
        $user['first_name']=$request->first_name;
        $user['last_name']=$request->last_name;
        $user['user_type']=$userType;
        $user['user_name']=$request->user_name;
        $user['email']=$request->email;
        if($request->password != '')
        {
            $user['password']=Hash::make($request->password);
        }
        $user['employee_id']=$request->employee_id;
        $user['mobile_no']=$request->mobile_no;
        $user['region_id']=$request->region_id;
        $user['unit_id']=$unitId;
        $user['group_id']=$groupId;
        $user['role_id']=$roleId;
        $user['isactive']=$request->isactive;
        $user['isadmin']=$request->isadmin;
        $user['is_all_complaint']=$request->is_all_complaint;
        $user['is_all_eform']=$request->is_all_eform;
        $user['update_datetime']= GetCurrentDateTime();
        $user->save();
        $this->ActivityLogs("Upate User [LoginId:$id, UserId:$request->user_name, Email:$request->email, User Type:$userType]");
        if($request->isadmin != "1"){
            if(!empty($id) && !empty($roleId)){
                $role=Role::select(DB::raw('GROUP_CONCAT(primary_name) as role_name'))->where('id',$roleId)->get();
                $roleName = $role[0]->role_name;
                $this->ActivityLogs("Add Role to User [LoginId: $id, UserId: $request->user_name, Roles Assign: $roleName]");
                DB::table('tbl_users_role')->where('user_id',$id)->update(['role_id'=>$roleId]);
            }
        }
        session()->flash('message', 'Successfully Updated!');
        session()->flash('alert-type', 'success');
       return $this->redirect();
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function GetAllRegion(Request $request)
    {
        $regionIds=$request->regionId;
        $data=DB::table('tbl_regions')->where('is_active','1')->orderBy('id','desc')->get();
        $sb = "<option value='0'> Select Region </option>";
        foreach($data as $region){

            $regionId        = $region->id;
            $regionName      = $region->region_name;
            $selected=$regionIds == $regionId ? "Selected" : '';
            $sb .= "<option value=".$regionId." $selected> $regionName </option>";
        }

        return $sb;
    }
    public function GetUnitRegion(Request $request)
    {
        
        $sb='';
        $data=Unit::where('region_id',$request->region_id)->get();
        $sb .= "<option value='0'> ALL </option>";

        foreach($data as $unit){

            $unit_id        = $unit->id;
            $unit_name      = $unit->unit_name;
            $branch_code    = $unit->branch_code;
            $branch_code    = $branch_code != "" ? "($branch_code)"  : "";
            $selected=$request->unitId==$unit_id ? 'Selected' : '';
            $sb .= "<option value=".$unit_id." $selected> $unit_name $branch_code </option>";
        }

        return $sb;

    }
    public function status($id)
    {
        $user=user::find($id);
        $status=$user->isactive == '1' ? '0' : '1';
        $user['isactive']=$status;
        $user->save();
        return $this->redirect();
    }
    private function redirect()
    {
        return redirect()->route('user.index');
    }
}
