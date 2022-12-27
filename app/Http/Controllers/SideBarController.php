<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class SideBarController extends Controller
{
    public function index(Request $request)
    {
        $dataSiderBarArr=[];
        $parentId=$request->parentId;
        $sidebarMenu=Session::get('sidebar_menu_box');
        for ($i=0; $i < count($sidebarMenu); $i++) { 
            if($sidebarMenu[$i]->parent_id == $parentId)
            {
                array_push($dataSiderBarArr,$sidebarMenu[$i]);
            }
        }
        // dd($dataSiderBarArr);
        return view('layouts/sidebar_box',compact('dataSiderBarArr'));
    }
}
