@extends('layouts.main')

@section('content')
<style>
    .grid-cols-12 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
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
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Add Message & Announcement
                    </h2>
                </div>
                <form  method="POST" action="{{ route('announcement_submit') }}" >
                    @csrf
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div>
                            <label for="regular-form-1" class="form-label">Type<span style="color: red">*</span></label>
                                <select data-placeholder="Select your favorite actors" name="type" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" required>
                                    <option value="news" >News</option>
                                    <option value="message" >Message</option>
                                </select>
                            </div>
                            <div>
                            <label for="regular-form-1" class="form-label">Subject<span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" name="subject" placeholder="Subject" aria-label="default input inline 2" required>
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Description <span style="color: red">*</span></label>
                            <textarea id="validation-form-6" class="form-control" name="description" onkeyup="validateAlphabetsAndNUumber(event)" placeholder="Description" minlength="10" maxlength='255' required></textarea>
                        </div>
                        <div class="form-check form-switch sm:mt-0" style="margin-top: 17px;margin-bottom: 10px;">
                            <label for="regular-form-1" class="form-label">IsActive</label>
                            <input id="show-example-3" data-target="#header" name="is_active" checked value="1" class="show-code form-check-input mr-0 ml-3" type="checkbox" >
                        </div>
                        </div>
                            <button type="submit" class="btn btn-primary mt-5">Save</button>
                    </div>
                   
                </div>
                </form>
           
        </div>
     
     
    </div>
</div>
@push('scripts')

@endpush

@endsection
