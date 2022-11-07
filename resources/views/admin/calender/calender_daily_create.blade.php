<form  method="POST" action="{{ route('daily_calendar.store') }}" style="margin-bottom: 47px;">
    @csrf
<div class="col-span-2 sm:col-span-2">
    <label for="modal-form-1" class="form-label">Effective From <span style="color: red">*</span></label>
    <div class="relative">
        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="calendar" data-lucide="calendar" class="lucide lucide-calendar w-4 h-4"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> </div>
        <input type="date" id='datepicker' name="effective_from" class=" form-control pl-12" data-single-mode="true" required>
    </div>
</div>
<div class="col-span-2 sm:col-span-2">
    <label for="modal-form-2" class="form-label">Effective To <span style="color: red">*</span></label>
    <div class="relative">
        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="calendar" data-lucide="calendar" class="lucide lucide-calendar w-4 h-4"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> </div>
        <input type="date" id='datepicker' name="effective_to" class="datepicker form-control pl-12" data-single-mode="true" required>
    </div>
</div>
<div class="col-span-2 sm:col-span-2">
    <label for="modal-form-2" class="form-label">Start Time <span style="color: red">*</span></label>
    <div class="relative">
        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="watch" data-lucide="watch" class="lucide lucide-watch block mx-auto"><circle cx="12" cy="12" r="7"></circle><polyline points="12 9 12 12 13.5 13.5"></polyline><path d="M16.51 17.35l-.35 3.83a2 2 0 01-2 1.82H9.83a2 2 0 01-2-1.82l-.35-3.83m.01-10.7l.35-3.83A2 2 0 019.83 1h4.35a2 2 0 012 1.82l.35 3.83"></path></svg> </div>
        <input type="time" id='datepicker'  name="start_time" class=" form-control pl-12" data-single-mode="true" required>
    </div>
</div>
<div class="col-span-2 sm:col-span-2">
    <label for="modal-form-2" class="form-label">End Time <span style="color: red">*</span></label>
    <div class="relative">
        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="watch" data-lucide="watch" class="lucide lucide-watch block mx-auto"><circle cx="12" cy="12" r="7"></circle><polyline points="12 9 12 12 13.5 13.5"></polyline><path d="M16.51 17.35l-.35 3.83a2 2 0 01-2 1.82H9.83a2 2 0 01-2-1.82l-.35-3.83m.01-10.7l.35-3.83A2 2 0 019.83 1h4.35a2 2 0 012 1.82l.35 3.83"></path></svg> </div>
        <input type="time" id='datepicker' name="end_time" class=" form-control pl-12" data-single-mode="true" required>
    </div>
</div>

<div class="mt-3 mr-5 absolute bottom-10 right-0">
    <button type="submit" class="btn btn-primary w-20">Add</button>
    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
</div>
</form>
