<?php

namespace App\Http\Controllers;

use App\Models\HolidaysCalendar;
use Illuminate\Http\Request;

class HolidaysCalendarController extends Controller
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
        return view('admin/calender/calender_eventholiday_create');
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
            'event_name' => ['required'],
            'from_date' => ['required'],
            'to_date' => ['required'],
        ]);
        $isRepeat=is_null($request->is_repeat) ? '0' : '1';
         
        $data = HolidaysCalendar::create([
            'event_name' => $request->event_name,
            'from_date' => Date("Y-m-d",strtotime($request->from_date)),
            'to_date' => Date("Y-m-d",strtotime($request->to_date)),
            'is_repeat' => $isRepeat,
            'created_datetime'=> GetCurrentDateTime(),
        ]);
        session()->flash('message', 'Successfully Saved!');
        session()->flash('alert-type', 'success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HolidaysCalendar  $holidaysCalendar
     * @return \Illuminate\Http\Response
     */
    public function show(HolidaysCalendar $holidaysCalendar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HolidaysCalendar  $holidaysCalendar
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $holidaysCalendar=HolidaysCalendar::find($id);
        return view('admin/calender/calender_eventholiday_edit',compact('holidaysCalendar'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HolidaysCalendar  $holidaysCalendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'event_name' => ['required'],
            'from_date' => ['required'],
            'to_date' => ['required'],
        ]);
        $isRepeat=is_null($request->is_repeat) ? '0' : '1';
        $holidaysCalendar=HolidaysCalendar::find($id);
        $holidaysCalendar['event_name']=$request->event_name;
        $holidaysCalendar['from_date']=Date("Y-m-d",strtotime($request->from_date));
        $holidaysCalendar['to_date']=Date("Y-m-d",strtotime($request->to_date));
        $holidaysCalendar['is_repeat']=$isRepeat;
        $holidaysCalendar['updated_datetime']=GetCurrentDateTime();
        $holidaysCalendar->save();
        session()->flash('message', 'Successfully Updated!');
        session()->flash('alert-type', 'success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HolidaysCalendar  $holidaysCalendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(HolidaysCalendar $holidaysCalendar)
    {
        //
    }
}
