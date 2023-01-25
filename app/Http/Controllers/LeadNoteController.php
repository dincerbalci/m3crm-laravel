<?php

namespace App\Http\Controllers;

use App\Models\LeadNote;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LeadNoteController extends Controller
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
        return view('admin/lead-note/lead_note_create',compact('leadId'));
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
            'note_title' => ['required'],
            'note_description' => ['required'],
            
        ]);
        $data = LeadNote::create([
            'user_id' => $loginId,
            'lead_id' => $request->lead_id,
            'note_title' => $request->note_title,
            'note_description' => $request->note_description,
        ]);
        session()->flash('message', 'Successfully Saved!');
        session()->flash('alert-type', 'success');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeadNote  $leadNote
     * @return \Illuminate\Http\Response
     */
    public function show(LeadNote $leadNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeadNote  $leadNote
     * @return \Illuminate\Http\Response
     */
    public function edit(LeadNote $leadNote)
    {
        return view('admin/lead-note/lead_note_edit',compact('leadNote'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeadNote  $leadNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeadNote $leadNote)
    {
        $request->validate([
            'note_title' => ['required'],
            'note_description' => ['required'],
        ]);

        $leadNote->note_title=$request->note_title;
        $leadNote->note_description=$request->note_description;
        $leadNote->save();

        session()->flash('message', 'Successfully Updated!');
        session()->flash('alert-type', 'success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeadNote  $leadNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeadNote $leadNote)
    {
        $leadNote->delete();
        session()->flash('message', 'Successfully Deleted!');
        session()->flash('alert-type', 'success');
        return redirect()->back();

    }
    public function leadNoteDelete(Request $request)
    {
        $id=$request->id;
        return view('admin/lead-note/lead_note_delete',compact('id'));
    }
}
