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
            Leads Management
        </h2>
    </div>
    <form id='complaint_form' method="POST" action="" >
        @csrf
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Add Leads
                    </h2>
                </div>
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div >
                                <label for="regular-form-1" class="form-label">Salutation </label>
                                <select data-placeholder="Select your favorite actors" name='product_category' class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" >
                                    <option value="0" selected="true">Select Salutation</option>
                                    <option value="0" >Mr.</option>
                                    <option value="0" >Mrs.</option>
                                    <option value="0" >Ms.</option>
                                </select>
                            </div>
                            <div>
                            <label for="regular-form-1" class="form-label">First Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" name="complaint_title" placeholder="First Name" aria-label="default input inline 2" required>
                            </div>
                            <div>
                            <label for="regular-form-1" class="form-label">Middle Name </label>
                            <input type="text" class="form-control col-span-4" name="complaint_title" placeholder="Middle Name" aria-label="default input inline 2" >
                            </div>
                            <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Last Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" name="complaint_title" placeholder="Last Name" aria-label="default input inline 2" required>
                            </div>
                            <div class="mt-3">
                            <label for="regular-form-1" class="form-label">CNIC <span style="color: red">*</span></label>
                            <input type="text" id="cnic" class="form-control col-span-4" name="cnic" placeholder="42201-XXXXXXX-X" aria-label="default input inline 2" required>
                            </div>
                            <div class="mt-3">
                                <label for="regular-form-1" class="form-label">Gender <span style="color: red">*</span></label>
                                <select data-placeholder="Select your favorite actors" name='product_category' class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" >
                                    <option value="0" selected="true">Select Gender</option>
                                    <option value="0" >Male</option>
                                    <option value="0" >Female</option>
                                    <option value="0" >Others</option>
                                </select>
                            </div>
                            <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Call Back Number <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4 number" name="call_back_phone" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" required>
                            </div>
                            <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Back Up Number <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4 number" name="call_back_phone" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" required>
                            </div>
                            <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Email</label>
                            <input type="email" class="form-control col-span-4" name="mother_maiden_name" placeholder="Email" aria-label="default input inline 1">
                            </div>
                            <div class="mt-3">
                                <label for="regular-form-1" class="form-label">City <span style="color: red">*</span></label>
                                <select data-placeholder="Select your favorite actors" name='product_category' class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" >
                                    <option value="0" selected="true">Select City</option>
                                    <option value="0" >Central</option>
                                    <option value="0" >North</option>
                                    <option value="0" >South</option>
                                </select>
                            </div>
                            <div class="mt-3">
                                <label for="regular-form-1" class="form-label">Area <span style="color: red">*</span></label>
                                <select data-placeholder="Select your favorite actors" name='product_category' class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" >
                                    <option value="0" selected="true">Select Area</option>
                                    
                                </select>
                            </div>
                            <div class="mt-3">
                                <label for="regular-form-1" class="form-label">Complete Address <span style="color: red">*</span></label>
                                <textarea id="validation-form-6" maxlength='255' class="form-control" name="note" placeholder="Complete Address" minlength="10" required=""></textarea>
                            </div>
                            <div class="mt-3">
                                <label for="regular-form-1" class="form-label">Product Name <span style="color: red">*</span></label>
                                <select data-placeholder="Select your favorite actors" name='product_category' class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" >
                                    <option value="0" selected="true">Select Product Name</option>
                                    <option value="0" >Conventional</option>
                                    <option value="0" >Takaful</option>
                                    <option value="0" >Vitality</option>
                                    <option value="0" >Personal Accident</option>
                                    <option value="0" >Corporate Solution GMD</option>
                                </select>
                            </div>
                            <div class="mt-3">
                                <label for="regular-form-1" class="form-label">Preferable Call Time <span style="color: red">*</span></label>
                                <input type="time" class="form-control col-span-4" name="card_number" placeholder="Preferable Call Time" aria-label="default input inline 1" required>
                            </div>
                            <div class="mt-3">
                                <label for="regular-form-1" class="form-label">Source of Information <span style="color: red">*</span></label>
                                <select data-placeholder="Select your favorite actors" name='product_category' class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" >
                                    <option value="0" selected="true">Select Source</option>
                                    <option value="0" >Email</option>
                                    <option value="0" >Call</option>
                                    <option value="0" >Letter</option>
                                    <option value="0" >Walk in Customer</option>
                                    <option value="0" >Website</option>
                                    <option value="0" >Corporate Partners</option>
                                    <option value="0" >Vitality Experience Center</option>
                                    <option value="0" >Other</option>
                                </select>
                            </div>
                            <div class="mt-3">
                                <label for="regular-form-1" class="form-label">Description<span style="color: red">*</span></label>
                                <textarea id="validation-form-6" maxlength='255' class="form-control" name="note" placeholder="Enter Details about inquiry" minlength="10" required=""></textarea>
                            </div>
                        </div>
                            <button type="button"  class="btn btn-primary mt-5">Save</button>
                    </div>
                </div>
            </div>
        </div>

</form>
</div>

@push('scripts')

@endpush

@endsection
