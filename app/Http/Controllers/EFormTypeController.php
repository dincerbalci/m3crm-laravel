<?php

namespace App\Http\Controllers;

use App\Models\EFormType;
use Illuminate\Http\Request;
use App\Models\EFormCategory;
use App\Models\EFormProduct;
use Illuminate\Support\Facades\DB;


class EFormTypeController extends Controller
{

    public  $objEFormType;

    public function __construct()
    {
        $this->objEFormType = new EFormType();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search=$request->search;
        $eFormType= $this->objEFormType->eFormType($search);
        $eFormType->appends(['search' => $search]);
        return view('admin/e-form-type/e_form_type_index',compact('eFormType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productCategory=EFormCategory::get();
        $groupIdArr=array('4','5');
        $group=DB::table('tbl_groups')->where('isactive','1')->whereIn('id',$groupIdArr)->get();
        $user= $this->objEFormType->GetUsers();
        return view('admin/e-form-type/e_form_type_create',compact('productCategory','group','user'));
        
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
            'product_category_id' => ['required'],
            'product_id' => ['required'],
            'type' => ['required'],
            'tat'=> ['required'],
        ]);
        $isActive=is_null($request->is_active) ? '0' : '1';
        $isSubscription=is_null($request->is_subscription) ? '0' : '1';
        $groupId=$request->operation_mode == '1' ? $request->group_id : '0';
        
        $data = EFormType::create([
            // 'group_id' => $groupId,
            'product_category_id' => $request->product_category_id,
            'product_id' => $request->product_id,
            // 'operation_mode'=>$request->operation_mode,
            'fullname' => $request->type,
            'tat' => $request->tat,
            'isactive' => $isActive,
            // 'is_subscription' => $isSubscription,
            'created_on' => GetCurrentDateTime(),
            'updated_on' => '0000-00-00 00:00:00',
        ]);
        $this->ActivityLogs("Add Eform Type [Eform Type Name:$request->type]");
        // $eFormEscalationId=$data->id;
        // if($eFormEscalationId > 0)
        // {
        //     DB::table('tbl_eform_type_escalation')->insert(
        //         [   'eform_escalation_id' => $eFormEscalationId, 
        //             'escalation_time1' => $request->escalation_time1, 
        //             'level1' => is_null($request->level1) ? '' : implode(",", $request->level1), 
        //             'escalation_time2' => $request->escalation_time2, 
        //             'level2' => is_null($request->level2) ? '' : implode(",", $request->level2), 
        //             'escalation_time3' => $request->escalation_time3, 
        //             'level3' => is_null($request->level3) ? '' : implode(",", $request->level3), 
        //             'escalation_time4' => $request->escalation_time4, 
        //             'level4' => is_null($request->level4) ? '' : implode(",", $request->level4),  
        //             'escalation_time5' => $request->escalation_time5,
        //             'level5' => is_null($request->level5) ? '' : implode(",", $request->level5), 
        //         ]
        //     );  
        // }
        session()->flash('message', 'Successfully Saved!');
        session()->flash('alert-type', 'success');
        return $this->redirect();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EFormType  $eFormType
     * @return \Illuminate\Http\Response
     */
    public function show(EFormType $eFormType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EFormType  $eFormType
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $productCategory=EFormCategory::get();
        $groupIdArr=array('4','5');
        $group=DB::table('tbl_groups')->where('isactive','1')->whereIn('id',$groupIdArr)->get();
        $user= $this->objEFormType->GetUsers();
        $eFormType=EFormType::find($id);
        $eFormTypeEscalation=DB::table('tbl_eform_type_escalation')->where('eform_escalation_id',$eFormType->id)->get();
        

        return view('admin/e-form-type/e_form_type_edit',compact('productCategory','group','user','eFormType','eFormTypeEscalation'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EFormType  $eFormType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'product_category_id' => ['required'],
            'product_id' => ['required'],
            'type' => ['required'],
            'tat'=> ['required'],
        ]);
        $isActive=is_null($request->is_active) ? '0' : '1';
        $isSubscription=is_null($request->is_subscription) ? '0' : '1';
        $groupId=$request->operation_mode == '1' ? $request->group_id : '0';
        $eFormType=EFormType::find($id);
        // $eFormType['group_id']=$groupId;
        $eFormType['product_category_id']=$request->product_category_id;
        $eFormType['product_id']=$request->product_id;
        // $eFormType['operation_mode']=$request->operation_mode;
        $eFormType['fullname']=$request->type;
        $eFormType['tat']= $request->tat;
        $eFormType['isactive']=$isActive;
        // $eFormType['is_subscription']=$isSubscription;
        $eFormType['updated_on']=GetCurrentDateTime();
        $eFormType->save();
        $this->ActivityLogs("Update Eform Type [Eform Type Name:$request->type]");
        // DB::table('tbl_eform_type_escalation')->where('eform_escalation_id', $id)
        // ->update([
        //         'escalation_time1' => $request->escalation_time1, 
        //         'level1' => is_null($request->level1) ? '' : implode(",", $request->level1), 
        //         'escalation_time2' => $request->escalation_time2, 
        //         'level2' => is_null($request->level2) ? '' : implode(",", $request->level2), 
        //         'escalation_time3' => $request->escalation_time3, 
        //         'level3' => is_null($request->level3) ? '' : implode(",", $request->level3), 
        //         'escalation_time4' => $request->escalation_time4, 
        //         'level4' => is_null($request->level4) ? '' : implode(",", $request->level4),  
        //         'escalation_time5' => $request->escalation_time5,
        //         'level5' => is_null($request->level5) ? '' : implode(",", $request->level5),
            
        //         ]);
        session()->flash('message', 'Successfully Updated!');
        session()->flash('alert-type', 'success');
        return $this->redirect();


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EFormType  $eFormType
     * @return \Illuminate\Http\Response
     */
    public function destroy(EFormType $eFormType)
    {
        //
    }
    private function redirect()
    {
        return redirect()->route('e_form_type.index');

    }
    public  function productCategory(Request $request)
    {
        $productCategoryId=$request->product_category_id;
        $eFormProduct=EFormProduct::where('product_category',$productCategoryId)->where('isactive','1')->get();
        
        return $eFormProduct;
    }
}
