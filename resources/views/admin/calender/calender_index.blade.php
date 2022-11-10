
@extends('layouts.main')

@section('content')
<style>
    .grid-cols-12 {
    grid-template-columns: repeat(4, minmax(0, 1fr));
}
</style>
<div class="content">
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Administration
        </h2>
        
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->
            <div class="intro-y box mt-5">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <ul class="nav nav-boxed-tabs" role="tablist">
                        <li id="example-1-tab" class="nav-item flex-1" role="presentation">
                            <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-1" type="button" role="tab" aria-controls="example-tab-3" aria-selected="true">Daily Hours </button>
                        </li>
                        <li id="example-2-tab" class="nav-item flex-1" role="presentation">
                            <button class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-2" type="button" role="tab" aria-controls="example-tab-4" aria-selected="false">Week Ends</button>
                        </li>
                        <li id="example-3-tab" class="nav-item flex-1" role="presentation">
                            <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-3" type="button" role="tab" aria-controls="example-tab-4" aria-selected="false">Event Holidays</button>
                        </li>
                    </ul>
                </div>
                <div id="boxed-tab" class="p-1">
                    <div class="preview">
                        <div class="tab-content">
                            <div id="example-tab-1" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-1-tab" style=""> 
                                <div class="overflow-x-auto scrollbar-hidden">
                                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                                        <table class="table table-report sm:mt-2">
                                            <thead>
                                                <tr>
                                                    <th class="whitespace-nowrap">Effective From</th>
                                                    <th class="whitespace-nowrap">Effective To</th>
                                                    <th class="whitespace-nowrap">Start Time</th>
                                                    <th class="whitespace-nowrap">End Time</th>
                                                    <th class="whitespace-nowrap">Action</th>
                                                    <th class="whitespace-nowrap"><button onclick="addDailyHours()"  class="px-4 py-3 rounded-full bg-success text-white mr-1"><div class="col-span-6 sm:col-span-3 lg:col-span-2 xl:col-span-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus block mx-auto"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> 
                                                    </div></button></th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                               
                                                @for ($i = 0; $i < count($dailyCalendar); $i++)
                                                <tr class="intro-x">
                                                    <td class="text-left">{{$dailyCalendar[$i]->effective_from}}</td>
                                                    <td class="text-left">{{$dailyCalendar[$i]->effective_to}}</td>
                                                    <td class="text-left">{{$dailyCalendar[$i]->start_time}}</td>
                                                    <td class="text-left">{{$dailyCalendar[$i]->end_time}}</td>
                                                    <td class="text-left flex"> 
                                                        <a class="flex items-center mr-3" href="#" onclick="editDailyHours('{{$dailyCalendar[$i]->id}}')"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                                        <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a></td>
                                                </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                                        {{ $dailyCalendar->links('paginate.paginate_ui') }}
                                    </div> --}}
                                   
                                </div>
                            </div>
                            <div id="example-tab-2" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-2-tab" style=""> 
                                <div class="overflow-x-auto scrollbar-hidden">
                                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                                        <table class="table table-report sm:mt-2">
                                            <thead>
                                                <tr>
                                                    <th class="whitespace-nowrap">Effective From</th>
                                                    <th class="whitespace-nowrap">Effective To</th>
                                                    <th class="whitespace-nowrap">Day Of Week</th>
                                                    <th class="whitespace-nowrap">Action</th>
                                                    <th class="whitespace-nowrap"><button onclick="addWeekEnd()"  class="px-4 py-3 rounded-full bg-success text-white mr-1"><div class="col-span-6 sm:col-span-3 lg:col-span-2 xl:col-span-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus block mx-auto"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> 
                                                    </div></button></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < count($weekendsCalendar); $i++)
                                                <tr class="intro-x">
                                                    <td class="text-left">{{$weekendsCalendar[$i]->effective_from}}</td>
                                                    <td class="text-left">{{$weekendsCalendar[$i]->effective_from}}</td>
                                                    <td class="text-left">{{$weekDays[$weekendsCalendar[$i]->week_day]}}</td>
                                                    <td class="text-left flex"> 
                                                        <a onclick="editWeekEnd('{{$weekendsCalendar[$i]->id}}')" class="flex items-center mr-3" href="#"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                                        <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a></td>
                                                  
                                                </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                                        {{ $weekendsCalendar->links('paginate.paginate_ui') }}
                                    </div> --}}
                                   
                                </div>   
                            </div>
                            <div id="example-tab-3" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-3-tab" style=""> 
                                <div class="overflow-x-auto scrollbar-hidden">
                                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                                        <table class="table table-report sm:mt-2">
                                            <thead>
                                                <tr>
                                                    <th class="whitespace-nowrap">Event</th>
                                                    <th class="whitespace-nowrap">From</th>
                                                    <th class="whitespace-nowrap">To</th>
                                                    <th class="whitespace-nowrap">Repeat Every Year</th>
                                                    <th class="whitespace-nowrap">Action</th>
                                                    <th class="whitespace-nowrap"><button onclick="addEventHoliday()"  class="px-4 py-3 rounded-full bg-success text-white mr-1"><div class="col-span-6 sm:col-span-3 lg:col-span-2 xl:col-span-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus block mx-auto"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> 
                                                    </div></button></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < count($holidaysCalendar); $i++)
                                                <tr class="intro-x">
                                                    <td class="text-left">{{ucwords($holidaysCalendar[$i]->event_name)}}</td>
                                                    <td class="text-left">{{$holidaysCalendar[$i]->from_date}}</td>
                                                    <td class="text-left">{{$holidaysCalendar[$i]->to_date}}</td>
                                                    <td class="text-left">{{$holidaysCalendar[$i]->is_repeat == '1' ? "YES" : "NO"}}</td>
                                                    <td class="text-left flex"> 
                                                        <a  onclick="editEventHoliday('{{$holidaysCalendar[$i]->id}}')" class="flex items-center mr-3" href="#"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                                        <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a></td>
                                                  
                                                </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                                        {{ $holidaysCalendar->links('paginate.paginate_ui') }}
                                    </div> --}}
                                </div>   
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


   <script>
       function addEventHoliday() {
        jQuery.ajax({
    type: 'GET',
    url: "{{ route('holidays.create') }}",
    success: function(result) {
        $('#myModalLgHeading').html('Holidays');
        $('#modalBodyLarge').html(result);
        tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview")).show();

    }
});
}
function editEventHoliday(id) {
        url = "{{ route('holidays.edit', ':id') }}";
        url = url.replace(':id', id);

        jQuery.ajax({
    type: 'GET',
    url: url,
    success: function(result) {
        $('#myModalLgHeading').html('Holidays Edit');
        $('#modalBodyLarge').html(result);
       tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview")).show();
    }
});
}
     function addWeekEnd() {
        jQuery.ajax({
    type: 'GET',
    url: "{{ route('week_end.create') }}",
    success: function(result) {
        $('#myModalLgHeading').html('Weekend');
        $('#modalBodyLarge').html(result);
        tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview")).show();

    }
});
}
function editWeekEnd(id) {
        url = "{{ route('week_end.edit', ':id') }}";
        url = url.replace(':id', id);
        jQuery.ajax({
    type: 'GET',
    url: url,
    success: function(result) {
        $('#myModalLgHeading').html('Weekend Edit');
        $('#modalBodyLarge').html(result);
        tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview")).show();

    }
});
}
       function addDailyHours() {
        jQuery.ajax({
    type: 'GET',
    url: "{{ route('daily_calendar.create') }}",
    success: function(result) {
        $('#myModalLgHeading').html('Daily Hours');
        $('#modalBodyLarge').html(result);
        tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview")).show();

    }
});
}
function editDailyHours(id) {
    url = "{{ route('daily_calendar.edit', ':id') }}";
        url = url.replace(':id', id);

        jQuery.ajax({
    type: 'GET',
    url: url,
    success: function(result) {
        $('#myModalLgHeading').html('Daily Hours Edit');
        $('#modalBodyLarge').html(result);
        tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview")).show();

    }
});
}
</script>        
   
@endsection
