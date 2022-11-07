<?php

namespace App\Http\Controllers;

use App\Models\EscalationGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EscalationGroupController extends Controller
{

    public  $objEscalationGroup;

    public function __construct()
    {
        $this->objEscalationGroup = new EscalationGroup();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search=$request->search;
        $escalationGroup=$this->objEscalationGroup->escalationGroup($search);
        $escalationGroup->appends(['search' => $search]);

        return view('admin/escalation-group/escalation_group_index',compact('escalationGroup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/escalation-group/escalation_group_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'group_name' => ['required'],
        ]);
        $isActive='1';

        $data = EscalationGroup::create([
            'full_name' => $request->group_name,
            'is_active' => $isActive,
        ]);
        $groupId=$data->id;
        $data=array();
        for ($i=0; $i < count($request->full_name); $i++) { 
            $user=array('group_id'=> $groupId, 'full_name'=>$request->full_name[$i],'email'=>$request->email[$i]);
            array_push($data,$user);
        }
        DB::table('tbl_escalation_group_users')->insert($data);
        $this->ActivityLogs("Add Escalation Group [Escalation Group Id: $groupId, Escalation Group Name: $request->group_name]");
        return $this->redirect();


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EscalationGroup  $escalationGroup
     * @return \Illuminate\Http\Response
     */
    public function show(EscalationGroup $escalationGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EscalationGroup  $escalationGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $escalationGroup=EscalationGroup::find($id);
        $escalationGroupMany=DB::table('tbl_escalation_group_users')->where('group_id',$id)->get();
        return view('admin/escalation-group/escalation_group_edit',compact('escalationGroup','escalationGroupMany'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EscalationGroup  $escalationGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'group_name' => ['required'],
        ]);
        $data=array();
        $escalationGroup=EscalationGroup::find($id);
        $escalationGroup['full_name']=$request->group_name;
        $escalationGroup->save();
        DB::table('tbl_escalation_group_users')->where('group_id',$id)->delete();
        for ($i=0; $i < count($request->full_name); $i++) { 
            $user=array('group_id'=> $id, 'full_name'=>$request->full_name[$i],'email'=>$request->email[$i]);
            array_push($data,$user);
        }
        DB::table('tbl_escalation_group_users')->insert($data);
        $this->ActivityLogs("Update Escalation Group [Escalation Group Id: $id, Escalation Group Name: $request->group_name]");
        return $this->redirect();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EscalationGroup  $escalationGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(EscalationGroup $escalationGroup)
    {
        //
    }
    private function redirect()
    {
        return redirect()->route('escalation_group.index');
    }
}
