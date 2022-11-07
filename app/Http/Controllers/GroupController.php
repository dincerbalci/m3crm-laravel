<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\GroupRequest;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search=$request->search;
        $paginationEnv=env('PAGINATION');
        $group=Group::where('id','<>','1')->orderby('id','desc')
        ->when($search, function ($query, $search) {
            return $query->whereRaw("CONCAT(group_name,email) like '%$search%'");
        })->paginate($paginationEnv);
        return view('admin/group/group_index',compact('group'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/group/group_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        $loginId = Session::get('login_id');
        $isActive=is_null($request->isactive) ? '0' : '1';
        
        $data = Group::create([
            'group_name' => $request->group_name,
            'email' => $request->email,
            'isactive' => $isActive,
            'created_by'=>$loginId,
            'created_on'=> GetCurrentDateTime(),
        ]);
        $this->ActivityLogs("Add Group [GroupId: $data->id, Group Name: $request->group_name]");
        return $this->redirect();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $group=Group::find($id);
        return view('admin/group/group_edit',compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, int $id)
    {
        $loginId = Session::get('login_id');
        $isActive=is_null($request->isactive) ? '0' : '1';
        $group=Group::find($id);
        $group['group_name']=$request->group_name;
        $group['email']=$request->email;
        $group['isactive']=$isActive;
        $group['updated_by']=$loginId;
        $group['updated_on']=GetCurrentDateTime();
        $group->save();
       
        $this->ActivityLogs("Update Group [GroupId: $id, Group Name: $request->group_name]");
        return $this->redirect();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }
    private function redirect()
    {
        return redirect()->route('group.index');
    }
}
