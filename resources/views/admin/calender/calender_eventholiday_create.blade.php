<form  method="POST" action="{{ route('holidays.store') }}" style="margin-bottom: 47px;">
    @csrf
<div class="col-span-2 sm:col-span-2">
    <label for="regular-form-1" class="form-label">Event </label>
    <input type="text" class="form-control col-span-4" name="event_name" placeholder="Enter Event"  aria-label="default input inline 1">
    </div>
<div class="col-span-2 sm:col-span-2">
    <label for="modal-form-1" class="form-label"> From</label>
    <div class="relative">
        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="calendar" data-lucide="calendar" class="lucide lucide-calendar w-4 h-4"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> </div>
        <input type="date" id='datepicker' name="from_date" class=" form-control pl-12" data-single-mode="true">
    </div>
</div>
<div class="col-span-2 sm:col-span-2">
    <label for="modal-form-2" class="form-label"> To</label>
    <div class="relative">
        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="calendar" data-lucide="calendar" class="lucide lucide-calendar w-4 h-4"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> </div>
        <input type="date" id='datepicker' name="to_date" class=" form-control pl-12" data-single-mode="true">
    </div>
</div>
<div class="col-span-2 sm:col-span-2" style="margin-top: 34px;">
    <label for="regular-form-1" class="form-label">Repeat Every Year</label>
    <input id="show-example-3" data-target="#header" name="is_repeat" value="1" class="show-code form-check-input mr-0 ml-3" type="checkbox">
</div>

<div class="mt-3 mr-5 absolute bottom-10 right-0">
    <button type="submit" class="btn btn-primary w-20">Add</button>
    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
</div>
</form>

