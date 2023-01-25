<?php

namespace App\Http\Controllers;

use App\Models\DailyCalendar;
use App\Models\WeekendsCalendar;
use App\Models\HolidaysCalendar;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DateTime;

class DailyCalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginationEnv=env('PAGINATION');
        $dailyCalendar=DailyCalendar::select(DB::raw("id, DATE_FORMAT(effective_from, '%M %d, %Y') AS effective_from,
        DATE_FORMAT(effective_to, '%M %d, %Y') AS effective_to,start_time, end_time"))->orderby('id','desc')->get();
        $weekendsCalendar=WeekendsCalendar::select(DB::raw("id, DATE_FORMAT(effective_from, '%M %d, %Y') AS effective_from,
        DATE_FORMAT(effective_to, '%M %d, %Y') AS effective_to,week_day"))->orderby('id','desc')->get();
        $holidaysCalendar=HolidaysCalendar::select(DB::raw("id,event_name, DATE_FORMAT(from_date, '%M %d, %Y') AS from_date,
        DATE_FORMAT(to_date, '%M %d, %Y') AS to_date,is_repeat"))->orderby('id','desc')->get();
        $weekDays=$this->weekDays();
        return view('admin/calender/calender_index',compact('dailyCalendar','weekendsCalendar','holidaysCalendar','weekDays'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/calender/calender_daily_create');
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
            'start_time' => ['required'],
            'end_time' => ['required'],
        ]);
         
        $data = DailyCalendar::create([
            'effective_from' => Date("Y-m-d",strtotime($request->effective_from)),
            'effective_to' => Date("Y-m-d",strtotime($request->effective_to)),
            'start_time' => Date("H:i:s",strtotime($request->start_time)),
            'end_time' => Date("H:i:s",strtotime($request->end_time)),
            'created_on'=> GetCurrentDateTime(),
        ]);
        session()->flash('message', 'Successfully Saved!');
        session()->flash('alert-type', 'success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DailyCalendar  $dailyCalendar
     * @return \Illuminate\Http\Response
     */
    public function show(DailyCalendar $dailyCalendar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DailyCalendar  $dailyCalendar
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $dailyCalendar=DailyCalendar::find($id);
        return view('admin/calender/calender_daily_edit',compact('dailyCalendar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DailyCalendar  $dailyCalendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'effective_from' => ['required'],
            'effective_to' => ['required'],
            'start_time' => ['required'],
            'end_time' => ['required'],
        ]);
        $dailyCalendar=DailyCalendar::find($id);
        $dailyCalendar['effective_from']=Date("Y-m-d",strtotime($request->effective_from));
        $dailyCalendar['effective_to']=Date("Y-m-d",strtotime($request->effective_to));
        $dailyCalendar['start_time']=Date("H:i:s",strtotime($request->start_time));
        $dailyCalendar['end_time']=Date("H:i:s",strtotime($request->end_time));
        $dailyCalendar['updated_on']=GetCurrentDateTime();
        $dailyCalendar->save();
        session()->flash('message', 'Successfully Updated!');
        session()->flash('alert-type', 'success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailyCalendar  $dailyCalendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyCalendar $dailyCalendar)
    {
        //
    }
    public function weekDays()
    {
        return $weekDays = array(
            'sat' => 'Saturday',
            'sun' => 'Sunday',
            'mon' => 'Monday',
            'tue' => 'Tuesday',
            'wed' => 'Wednesday',
            'thurs'=> 'Thursday',
            'fri' => 'Friday');
    }
}
