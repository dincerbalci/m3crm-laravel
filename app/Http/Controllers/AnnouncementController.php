<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AnnouncementRequest;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginationEnv=env('PAGINATION');
        $search=$request->search;
        $announcement=Announcement::orderby('id','desc')
        ->when($search, function ($query, $search) {
            $query->whereRaw("CONCAT(type,subject) like '%$search%'");
        })
        ->paginate($paginationEnv);
        $announcement->appends(['search' => $search]);
        return view('admin/announcement/announcement_index',compact('announcement'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/announcement/announcement_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnouncementRequest $request)
    {
        $loginId = Session::get('login_id');
        $data = Announcement::create([
            'user_id' => $loginId,
            'subject' => $request->subject,
            'description' => $request->description,
            'type' => $request->type,
            'is_active' => $request->is_active,
            'created_at' => GetCurrentDate(),
        ]);
        $this->ActivityLogs("Add Announcement tbl_announcements [AnnouncementId:$data->id, subject: $request->subject]");
        return $this->redirect();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $announcement=Announcement::find($id);
        return view('admin/announcement/announcement_edit',compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(AnnouncementRequest $request, int $id)
    {
        $announcement=Announcement::find($id);
        $announcement['subject']=$request->subject;
        $announcement['description']=$request->description;
        $announcement['type']=$request->type;
        $announcement['is_active']=$request->is_active;
        $announcement['updated_at']=GetCurrentDate();
        $announcement->save();
        return $this->redirect();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $data = Announcement::find($id);
        $data->delete();
        return redirect()->back();
    }
    public function destroyShow(Request $request)
    {
        $id=$request->id;
        return view('admin/announcement/annoucement_delete',compact('id'));

    }
    private function redirect()
    {   
        return redirect()->route('announcement_index');
    }
}
