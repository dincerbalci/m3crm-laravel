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
            E-Form Management
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Add E-form
                    </h2>
                </div>
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div>
                            <label for="regular-form-1" class="form-label">E-Form Num</label>
                            <input type="text" class="form-control col-span-4" placeholder="E-Form Num" aria-label="default input inline 1">
                            </div>
                            <div>
                            <label for="regular-form-1" class="form-label">CNIC <span style="color: red">*</span></label>
                            <input type="text" id='cnic' class="form-control col-span-4" placeholder="CNIC" aria-label="default input inline 2">
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Customer Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" placeholder="Customer Name" aria-label="default input inline 2">
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Mother Maiden Name</label>
                            <input type="text" class="form-control col-span-4" placeholder="Mother Maiden Name" aria-label="default input inline 1">
                            </div>
                            <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Date of Birth </label>
                            <div id="basic-datepicker">
                                <div class="preview">
                                    <input type="text" class="datepicker form-control  block mx-auto" data-single-mode="true">
                                </div>
                               
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Priority</label>
                                <select data-placeholder="Select your favorite actors" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="0" selected="true">Select priority </option>
                                    <option value="3" >Robert Downey, Jr</option>
                                    <option value="1">Leonardo DiCaprio</option>
                                    <option value="2">Johnny Deep</option>
                                    <option value="4">Samuel L. Jackson</option>
                                    <option value="5">Morgan Freeman</option>
                                </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Product Category <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                <option value="0" selected="true">Select product category </option>
                                <option value="3" >Robert Downey, Jr</option>
                                <option value="1">Leonardo DiCaprio</option>
                                <option value="2">Johnny Deep</option>
                                <option value="4">Samuel L. Jackson</option>
                                <option value="5">Morgan Freeman</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Product<span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                <option value="0" selected="true">Select product</option>
                                <option value="3" >Robert Downey, Jr</option>
                                <option value="1">Leonardo DiCaprio</option>
                                <option value="2">Johnny Deep</option>
                                <option value="4">Samuel L. Jackson</option>
                                <option value="5">Morgan Freeman</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">E-Form Type<span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                <option value="0" selected="true">Select E-Form Type</option>
                                <option value="3" >Robert Downey, Jr</option>
                                <option value="1">Leonardo DiCaprio</option>
                                <option value="2">Johnny Deep</option>
                                <option value="4">Samuel L. Jackson</option>
                                <option value="5">Morgan Freeman</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Account Number </label>
                            <input type="text" class="form-control col-span-4" placeholder="Account Number" onkeypress="return validateNumbers(event)" aria-label="default input inline 2">
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Card Number</label>
                            <select data-placeholder="Select your favorite actors" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                <option value="0" selected="true">Select Card Number</option>
                                <option value="3" >Robert Downey, Jr</option>
                                <option value="1">Leonardo DiCaprio</option>
                                <option value="2">Johnny Deep</option>
                                <option value="4">Samuel L. Jackson</option>
                                <option value="5">Morgan Freeman</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Card Title</label>
                            <input type="text" class="form-control col-span-4" placeholder="Account Number" onkeypress="return validateNumbers(event)" aria-label="default input inline 2">
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Customer Branch</label>
                            <select data-placeholder="Select your favorite actors" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                <option value="0" selected="true">Select  Branch</option>
                                <option value="3" >Robert Downey, Jr</option>
                                <option value="1">Leonardo DiCaprio</option>
                                <option value="2">Johnny Deep</option>
                                <option value="4">Samuel L. Jackson</option>
                                <option value="5">Morgan Freeman</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Notes</label>
                            <textarea id="validation-form-6" class="form-control" name="comment" placeholder="Additional Information" minlength="10" required=""></textarea>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Select File</label>
                            <input type="file" class="form-control col-span-4" placeholder="Account Number" aria-label="default input inline 2">

                        </div>
                        
                        </div>
                        
                    </div>
                   
                </div>
           
        </div>
     
     
    </div>
    <div class="intro-y col-span-12 lg:col-span-6">
        <!-- BEGIN: Input -->
        <div class="intro-y box">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Call Back Log
                </h2>
            </div>
            <div id="inline-form" class="p-5">
                <div class="preview">
                    <div class="grid grid-cols-12 gap-2">
                        <div>
                        <label for="regular-form-1" class="form-label">Call Back Phone <span style="color: red">*</span></label>
                        <input type="text" class="form-control col-span-4 number" placeholder="92-xxxxxxxxxx" onkeypress="return validateNumbers(event)"  aria-label="default input inline 1">
                        </div>
                        <div>
                        <label for="regular-form-1" class="form-label">Telephone No (Office)</label>
                        <input type="text" class="form-control col-span-4 number" placeholder="92-xxxxxxxxxx" onkeypress="return validateNumbers(event)"  aria-label="default input inline 2">
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Residence Address <span style="color: red">*</span></label>
                        <textarea id="validation-form-6" class="form-control" name="comment" placeholder="Residence Address" minlength="10" required=""></textarea>
                    </div>
                    
                    </div>
                </div>
            </div>
       
    </div>
   
    
 
 
</div>
<div class="intro-y col-span-12 lg:col-span-6">
    <!-- BEGIN: Input -->
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
                Acknowledge Response
            </h2>
        </div>
        <div id="inline-form" class="p-5">
            <div class="preview">
                <div class="grid grid-cols-12 gap-2">
                    <div>
                    <label for="regular-form-1" class="form-label">E-Mail</label>
                    <div class="flex flex-col sm:flex-row mt-2">
                        <div class="form-check mr-2">
                            <input id="radio-switch-4" class="form-check-input" type="radio" name="horizontal_radio_button" value="horizontal-radio-chris-evans">
                            <label class="form-check-label" for="radio-switch-4">Yes</label>
                        </div>
                        <div class="form-check mr-2 mt-2 sm:mt-0">
                            <input id="radio-switch-5" class="form-check-input" type="radio" name="horizontal_radio_button" value="horizontal-radio-liam-neeson">
                            <label class="form-check-label" for="radio-switch-5">No</label>
                        </div>
                    </div>
                    </div>
                    <div>
                    <label for="regular-form-1" class="form-label">Customer E-Mail</label>
                    <div class="input-group">
                        <div id="input-group-email" class="input-group-text">@</div>
                        <input type="text" class="form-control" placeholder="abc@gmail.com" aria-label="Email" aria-describedby="input-group-email">
                    </div>
                </div>
                <div>
                    <label for="regular-form-1" class="form-label">SMS</label>
                    <div class="flex flex-col sm:flex-row mt-2">
                        <div class="form-check mr-2">
                            <input id="radio-switch-1" class="form-check-input" type="radio" name="horizontal_radio_button1" value="horizontal-radio-chris-evans1">
                            <label class="form-check-label" for="radio-switch-1">Yes</label>
                        </div>
                        <div class="form-check mr-2 mt-2 sm:mt-0">
                            <input id="radio-switch-2" class="form-check-input" type="radio" name="horizontal_radio_button1" value="horizontal-radio-liam-neeson1">
                            <label class="form-check-label" for="radio-switch-2">No</label>
                        </div>
                        
                    </div>
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Customer Mobile </label>
                        <input type="text" maxlength="12" class="form-control col-span-4 number" placeholder="92-xxxxxxxxxx" onkeypress="return validateNumbers(event)"  aria-label="default input inline 1">
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Call Back</label>
                            <div class="flex flex-col sm:flex-row mt-2">
                                <div class="form-check mr-2">
                                    <input id="radio-switch-7" class="form-check-input" type="radio" name="horizontal_radio_button7" value="horizontal-radio-chris-evans1">
                                    <label class="form-check-label" for="radio-switch-7">Yes</label>
                                </div>
                                <div class="form-check mr-2 mt-2 sm:mt-0">
                                    <input id="radio-switch-8" class="form-check-input" type="radio" name="horizontal_radio_button8" value="horizontal-radio-liam-neeson1">
                                    <label class="form-check-label" for="radio-switch-8">No</label>
                                </div>
                                
                            </div>
                            </div>
                </div>
                <button type="submit" class="btn btn-primary mt-5">Save</button>

            </div>
        </div>
   
</div>
</div>
    


@endsection
