<?php

namespace App\Http\Controllers;

use App\Models\ComplaintType;
use Illuminate\Http\Request;
use App\Models\ComplaintCategory;


class ComplaintTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search=$request->search;
        $objComplaintType= new ComplaintType();
        $complaintType= $objComplaintType->complaintType($search);
        $complaintType->appends(['search' => $search]);
        return view('admin/complaint-type/complaint_type_index',compact('complaintType'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $complaintCategory=ComplaintCategory::where('isactive','1')->whereNull('end_date')->orderBy('fullname')->get();
        $complaintCategory=ComplaintCategory::where('isactive','1')->orderBy('fullname')->get();
        return view('admin/complaint-type/complaint_type_create',compact('complaintCategory'));
        
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
            'product_category' => ['required'],
            'product' => ['required'],
            'complaint_type' => ['required'],
            'turn_around_time' => ['required'],
        ]);

        $isactive=is_null($request->is_active) ? '0' : '1';
        
        $data = ComplaintType::create([
            'group_id' => '0',
            'product_category_id' => $request->product_category,
            'product_id' => $request->product,
            'fullname' => $request->complaint_type,
            'tat' => $request->turn_around_time,
            'operation_mode' => '0',
            'isactive' => $isactive,
            'created_on' => GetCurrentDate(),
            
        ]);

        $this->ActivityLogs("Add Complaint Type [Complaint Type Name:$request->complaint_type]");
        session()->flash('message', 'Successfully Saved!');
        session()->flash('alert-type', 'success');
        return $this->redirect();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ComplaintType  $complaintType
     * @return \Illuminate\Http\Response
     */
    public function show(ComplaintType $complaintType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComplaintType  $complaintType
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $complaintType=ComplaintType::find($id);
    // $complaintCategory=ComplaintCategory::where('isactive','1')->whereNull('end_date')->orderBy('fullname')->get();
    $complaintCategory=ComplaintCategory::where('isactive','1')->orderBy('fullname')->get();
    return view('admin/complaint-type/complaint_type_edit',compact('complaintCategory','complaintType'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ComplaintType  $complaintType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'product_category' => ['required'],
            'product' => ['required'],
            'complaint_type' => ['required'],
            'turn_around_time' => ['required'],
        ]);

        $isactive=is_null($request->is_active) ? '0' : '1';
        $complaintProduct = ComplaintType::find($id);
        $complaintProduct['product_category_id']=$request->product_category;
        $complaintProduct['product_id']=$request->product;
        $complaintProduct['fullname']=$request->complaint_type;
        $complaintProduct['tat']=$request->turn_around_time;
        $complaintProduct['updated_on']=GetCurrentDate();
        $complaintProduct['isactive']=$isactive;
        $complaintProduct->save();
        $this->ActivityLogs("Edit Complaint Type [Complaint Type Name:$request->complaint_type]");
        session()->flash('message', 'Successfully Updated!');
        session()->flash('alert-type', 'success');
        return $this->redirect();
    }
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComplaintType  $complaintType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComplaintType $complaintType)
    {
        //
    }
    private function redirect()
    {
        return redirect()->route('complaint_type_index');

    }
}
