<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public  $objRole;

      public function __construct()
    {
        $this->objRole = new Role();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search=$request->search;
        $paginationEnv=env('PAGINATION');
        $role=Role::when($search, function ($query, $search) {
            return $query->whereRaw("CONCAT(primary_name,secondary_name) like '%$search%'");
        })->orderby('id','desc')->paginate($paginationEnv);
        $role->appends(['search' => $search]);
        return view('admin/role/role_index',compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent=$this->objRole->GetParentModules();
        return view('admin/role/role_create',compact('parent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $data = Role::create([
            'primary_name' => $request->primary_name,
            'secondary_name' => $request->secondary_name,
            'email' => $request->email,
            'expiry_date' => $request->expiry_date,
            'isactive' => $request->isactive,
            'created_on'=> GetCurrentDateTime(),
        ]);
        $id=$data->id;
        $data=array();
        for ($i=0; $i < count($request->table_json); $i++) { 
            if($request->table_json[$i]->moduleid != '')
            {
                $user=array('role_id'=> $id, 'module_id'=>$request->table_json[$i]->moduleid,
                            'create'=>$request->table_json[$i]->create,'update'=>$request->table_json[$i]->update,
                            'delete'=>$request->table_json[$i]->delete,'view'=>$request->table_json[$i]->view);
                array_push($data,$user);
            }
        }
        DB::table('tbl_roles_permissions')->insert($data);
        session()->flash('message', 'Successfully Saved!');
        session()->flash('alert-type', 'success');
        return $this->redirect();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $role=Role::find($id);
        $parent=$this->objRole->GetParentModules();
        $permissions=DB::table('tbl_roles_permissions')->where('role_id',$id)->get();
        return view('admin/role/role_edit',compact('role','parent','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, int $id)
    {
        $role=Role::find($id);
        $role['primary_name']=$request->primary_name;
        $role['secondary_name']=$request->secondary_name;
        $role['email']=$request->email;
        $role['expiry_date']=$request->expiry_date;
        $role['updated_on']=GetCurrentDateTime();
        $role->save();
        DB::table('tbl_roles_permissions')->where('role_id',$id)->delete();
        $data=array();
        for ($i=0; $i < count($request->table_json); $i++) { 
            if($request->table_json[$i]->moduleid != '')
            {
                $user=array('role_id'=> $id, 'module_id'=>$request->table_json[$i]->moduleid,
                            'create'=>$request->table_json[$i]->create,'update'=>$request->table_json[$i]->update,
                            'delete'=>$request->table_json[$i]->delete,'view'=>$request->table_json[$i]->view);
                array_push($data,$user);
            }
        }
        DB::table('tbl_roles_permissions')->insert($data);
        session()->flash('message', 'Successfully Updated!');
        session()->flash('alert-type', 'success');
        return $this->redirect();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
    private function redirect()
    {
        return redirect()->route('role.index');
    }
    
}
