<?php

namespace App\Http\Controllers;

use App\Models\WeekendsCalendar;
use App\Http\Controllers\DailyCalendarController;
use Illuminate\Http\Request;

class WeekendsCalendarController extends Controller
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
    public function create()
    {
       $objDailyCalendarController=new DailyCalendarController();
        $weekDays = $objDailyCalendarController->weekDays();

        return view('admin/calender/calender_weekend_create',compact('weekDays'));
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
            'effective_from' => ['required'],
            'effective_to' => ['required'],
            'week_day' => ['required'],
        ]);
         
        $data = WeekendsCalendar::create([
            'effective_from' => Date("Y-m-d",strtotime($request->effective_from)),
            'effective_to' => Date("Y-m-d",strtotime($request->effective_to)),
            'week_day' => $request->week_day,
            'created_on'=> GetCurrentDateTime(),
        ]);
        session()->flash('message', 'Successfully Saved!');
        session()->flash('alert-type', 'success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WeekendsCalendar  $weekendsCalendar
     * @return \Illuminate\Http\Response
     */
    public function show(WeekendsCalendar $weekendsCalendar)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WeekendsCalendar  $weekendsCalendar
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
       $objDailyCalendarController=new DailyCalendarController();

        $weekDays = $objDailyCalendarController->weekDays();
        $weekEndCalendar=WeekendsCalendar::find($id);
        return view('admin/calender/calender_weekend_edit',compact('weekDays','weekEndCalendar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WeekendsCalendar  $weekendsCalendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'effective_from' => ['required'],
            'effective_to' => ['required'],
            'week_day' => ['required'],
        ]);
        $weekEnd=WeekendsCalendar::find($id);
        $weekEnd['effective_from']=Date("Y-m-d",strtotime($request->effective_from));
        $weekEnd['effective_to']=Date("Y-m-d",strtotime($request->effective_to));
        $weekEnd['week_day']=$request->week_day;
        $weekEnd['updated_on']=GetCurrentDateTime();
        $weekEnd->save();
        session()->flash('message', 'Successfully Updated!');
        session()->flash('alert-type', 'success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WeekendsCalendar  $weekendsCalendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(WeekendsCalendar $weekendsCalendar)
    {
        //
    }
}
