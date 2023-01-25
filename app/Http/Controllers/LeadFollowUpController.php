<?php

namespace App\Http\Controllers;

use App\Models\LeadFollowUp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LeadFollowUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $leadId=$request->id;
        return view('admin/lead-follow-up/lead_follow_up_create',compact('leadId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loginId = Session::get('login_id');
        $request->validate([
            'next_follow_up' => ['required'],
            'remark' => ['required'],
            
        ]);
        $data = LeadFollowUp::create([
            'user_id' => $loginId,
            'lead_id' => $request->lead_id,
            'next_follow_up' => DATE("Y-m-d H:i:s",strtotime($request->next_follow_up)),
            'remark' => $request->remark,
        ]);
        session()->flash('message', 'Successfully Saved!');
        session()->flash('alert-type', 'success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeadFollowUp  $leadFollowUp
     * @return \Illuminate\Http\Response
     */
    public function show(LeadFollowUp $leadFollowUp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeadFollowUp  $leadFollowUp
     * @return \Illuminate\Http\Response
     */
    public function edit(LeadFollowUp $leadFollowUp)
    {
        return view('admin/lead-follow-up/lead_follow_up_edit',compact('leadFollowUp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeadFollowUp  $leadFollowUp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeadFollowUp $leadFollowUp)
    {
        $request->validate([
            'next_follow_up' => ['required'],
            'remark' => ['required'],
        ]);
        // $leadFollowUp->next_follow_up=date("Y-m-d H:i:s",strtotime($request->next_follow_up));
        $leadFollowUp->update($request->all());
        session()->flash('message', 'Successfully Updated!');
        session()->flash('alert-type', 'success');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeadFollowUp  $leadFollowUp
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeadFollowUp $leadFollowUp)
    {
        $leadFollowUp->delete();
        session()->flash('message', 'Successfully Deleted!');
        session()->flash('alert-type', 'success');
        return redirect()->back();

    }
    
    
    public function leadFollowUpDelete(Request $request)
    {
        $id=$request->id;
        return view('admin/lead-follow-up/lead_follow_up_delete',compact('id'));
    }
}
