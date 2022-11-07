<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Support\Facades\Session;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Requests\UnitRequest;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
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
        $unit=Unit::orderby('id','desc')
        ->when($search, function ($query, $search) {
            return $query->whereRaw("CONCAT(branch_code,unit_name) like '%$search%'");
        })->paginate($paginationEnv);
        return view('admin/organization-unit/unit_index',compact('unit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $objUnit = new Unit();
        $escalationGroup=$objUnit->escalationGroup();
        $group=Group::where('isactive','1')->where('id','<>','1')->get();
        $region=DB::table('tbl_regions')->where('is_active','1')->orderBy('id','desc')->get();
        $tatSave=10;
        return view('admin/organization-unit/unit_create',compact('group','region','tatSave','escalationGroup'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
        $isActive=is_null($request->is_active) ? '0' : '1';
        $loginId = Session::get('login_id');
        $data = Unit::create([
            'group_id' => $request->group_id,
            'region_id' => $request->region_id,
            'unit_name' => $request->unit_name,
            'branch_code' => $request->branch_code,
            'address' => $request->address,
            'email' => $request->email,
            'is_active' => $isActive,
            'created_by'=>$loginId,
            'created_on'=> GetCurrentDateTime(),
        ]);
        $unitId=$data->id;
        if($unitId > 0)
        {
            DB::table('tbl_escalation_branches')->insert(
                [   'branch_id' => $unitId, 
                    'escalation_time1' => $request->escalation_time1, 
                    'level1' => $request->level1, 
                    'escalation_time2' => $request->escalation_time2, 
                    'level2' => $request->level2, 
                    'escalation_time3' => $request->escalation_time3, 
                    'level3' => $request->level3, 
                    'escalation_time4' => $request->escalation_time4, 
                    'level4' => $request->level4,  
                ]
            );  
        }

        return $this->redirect();
    }
    // 
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $unit=Unit::find($id);
        $objUnit = new Unit();
        $escalationGroup=$objUnit->escalationGroup();
        $group=Group::where('isactive','1')->where('id','<>','1')->get();
        $region=DB::table('tbl_regions')->where('is_active','1')->orderBy('id','desc')->get();
        $escalationBranches=DB::table('tbl_escalation_branches')->where('branch_id',$id)->get();
        $tatSave=10;

        return view('admin/organization-unit/unit_edit',compact('unit','escalationGroup','group','region','tatSave','escalationBranches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(UnitRequest $request, int $id)
    {
        $isActive=is_null($request->is_active) ? '0' : '1';
        $loginId = Session::get('login_id');
        $unit=Unit::find($id);
        $unit['group_id']=$request->group_id;
        $unit['region_id']=$request->region_id;
        $unit['unit_name']=$request->unit_name;
        $unit['branch_code']=$request->branch_code;
        $unit['address']=$request->address;
        $unit['email']=$request->email;
        $unit['is_active']=$isActive;
        $unit['updated_by']=$loginId;
        $unit['updated_on']=GetCurrentDateTime();
        $unit->save();
        DB::table('tbl_escalation_branches')->where('branch_id',$id)->update(
            [   'branch_id' => $id, 
                'escalation_time1' => $request->escalation_time1, 
                'level1' => $request->level1, 
                'escalation_time2' => $request->escalation_time2, 
                'level2' => $request->level2, 
                'escalation_time3' => $request->escalation_time3, 
                'level3' => $request->level3, 
                'escalation_time4' => $request->escalation_time4, 
                'level4' => $request->level4,  
            ]
        );  
        return $this->redirect();

      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        //
    }
    private function redirect()
    {
        return redirect()->route('unit.index');
    }
}
