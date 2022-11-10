<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class DashboardController extends Controller
{
    public function index()
    {
        $news=Announcement::where('type','news')->where('is_active','1')->orderby('id','desc')->get();
        $message=Announcement::where('type','message')->where('is_active','1')->orderby('id','desc')->get();
        return view('dashboard',compact('message','news'));

    }
}
