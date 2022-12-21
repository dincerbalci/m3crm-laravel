<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
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
        $userId=Auth::user()->id;
        $group=Group::where('isactive','1')->where('id','!=','1')->get();
        $user=User::where('user_type','!=','1')->where('id','!=',$userId)->get();
        return view('admin/announcement/announcement_create',compact('group','user'));
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
        $userId='';
        $path='';
        if ($request->hasFile('file')) {
            $file = $request->file('file');
                $file_name = time() . $file->getClientOriginalName();
                $size = $file->getSize();
                $destinationPath = base_path('public/uploads/messagefile/' . $loginId);
                $file->move($destinationPath, $file_name);
                $path = 'uploads/messagefile/' . $loginId . "/" . $file_name;
        }
        if(isset($request->forward_to_user))
        {
            $userId=implode(',',$request->forward_to_user);
        }
        $data = Announcement::create([
            'user_id' => $loginId,
            'subject' => $request->subject,
            'description' => $request->description,
            'type' => $request->type,
            'forward_to_user_type' => $request->forward_to_user_type,
            'forward_to_user' => $userId,
            'path' => $path,
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
        $userId=Auth::user()->id;
        $announcement=Announcement::find($id);
        $group=Group::where('isactive','1')->where('id','!=','1')->get();
        $user=User::where('user_type','!=','1')->where('id','!=',$userId)->get();
        return view('admin/announcement/announcement_edit',compact('announcement','group','user'));
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
        $loginId = Session::get('login_id');
        $announcement=Announcement::find($id);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            File::delete($announcement->path);
                $file_name = time() . $file->getClientOriginalName();
                $size = $file->getSize();
                $destinationPath = base_path('public/uploads/messagefile/' . $loginId);
                $file->move($destinationPath, $file_name);
                $path = 'uploads/messagefile/' . $loginId . "/" . $file_name;
                $announcement['path']=$path;

        }
        if(isset($request->forward_to_user))
        {
            $userId=implode(',',$request->forward_to_user);
            $announcement['forward_to_user']=$userId;
        }
        $announcement['subject']=$request->subject;
        $announcement['description']=$request->description;
        $announcement['forward_to_user_type']=$request->forward_to_user_type;
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
        File::delete($data->path);
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
