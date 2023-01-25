<?php

namespace App\Http\Controllers;

use App\Models\LeadFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class LeadFileController extends Controller
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
        return view('admin/lead-file/lead_file_create',compact('leadId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = Session::get('login_id');
        if ($request->hasFile('file')) {
            for ($i=0; $i < count($request->file('file')) ; $i++) { 
            $destinationPath = base_path('public/uploads/leadfile/' . $userId);
            $file = $request->file('file');
            $filename = date('YmdHi') . $file[$i]->getClientOriginalName();
            $size = $file[$i]->getSize();
            $file[$i]->move($destinationPath, $filename);
            $path = "uploads/leadfile/" .$userId . "/". $filename;
            LeadFile::create([
                'user_id'=>$userId,
                'lead_id' => $request->lead_id,
                'path' => $path,
                'ext' => $file[$i]->getClientOriginalExtension(),
                'size' =>  formatSizeUnits($size),
                'file_name' => $file[$i]->getClientOriginalName(),
            ]);
        }

        }
        session()->flash('message', 'Successfully Saved!');
        session()->flash('alert-type', 'success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeadFile  $leadFile
     * @return \Illuminate\Http\Response
     */
    public function show(LeadFile $leadFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeadFile  $leadFile
     * @return \Illuminate\Http\Response
     */
    public function edit(LeadFile $leadFile)
    {
        return view('admin/lead-file/lead_file_edit',compact('leadFile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeadFile  $leadFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeadFile $leadFile)
    {
        $userId = Session::get('login_id');
        if ($request->hasFile('file')) {
            File::delete($leadFile->path);
            $destinationPath = base_path('public/uploads/leadfile/' . $userId);
            $file = $request->file('file');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $size = $file->getSize();
            $file->move($destinationPath, $filename);
            $path = "uploads/leadfile/" .$userId . "/". $filename;
            $leadFile['file_name'] = $file->getClientOriginalName();
            $leadFile['size'] = formatSizeUnits($size);
            $leadFile['path'] = $path;
            $leadFile['ext'] = $file->getClientOriginalExtension();
        }
        $leadFile->save();
        session()->flash('message', 'Successfully Updated!');
        session()->flash('alert-type', 'success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeadFile  $leadFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeadFile $leadFile)
    {
        File::delete($leadFile->path);
        $leadFile->delete();
        session()->flash('message', 'Successfully Deleted!');
        session()->flash('alert-type', 'success');
        return redirect()->back();
    }
    
    public function leadFileDelete(Request $request)
    {
        $id=$request->id;
        return view('admin/lead-file/lead_file_delete',compact('id'));
    }

    

}
