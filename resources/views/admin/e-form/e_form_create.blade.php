@extends('layouts.main')

@section('content')
<style>
    .grid-cols-12 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
}
</style>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            E-Form Management
        </h2>
    </div>
    <form  method="POST" action="{{ route('e_form_store') }}" enctype="multipart/form-data">
        @csrf
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
                            <label for="regular-form-1" class="form-label">CNIC <span style="color: red">*</span></label>
                            <input type="text" id='cnic' name="cnic" class="form-control col-span-4" onkeypress="return validateNumbers(event);" placeholder="CNIC" aria-label="default input inline 2" required>
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Customer Name <span style="color: red">*</span></label>
                            <input type="text" name="customer_name" class="form-control col-span-4" placeholder="Customer Name" onkeypress="return validateAlphabets(event);"  aria-label="default input inline 2" required>
                        </div>
                        <div >
                            <label for="regular-form-1" class="form-label">Mother Maiden Name</label>
                            <input type="text" name="mother_maiden_name" class="form-control col-span-4" placeholder="Mother Maiden Name" onkeypress="return validateAlphabets(event);"  aria-label="default input inline 1">
                            </div>
                            <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Date of Birth </label>
                            <div id="basic-datepicker">
                                <div class="preview">
                                    <input type="text" name="dob" class="datepicker form-control  block mx-auto" onkeypress="return validateAlphabets(event);"  data-single-mode="true">
                                </div>
                               
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Priority</label>
                                <select data-placeholder="Select your favorite actors" name="priority" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="0" selected="true">Select priority </option>
                                    @for($i=0; $i < count($priority); $i++ )
                                    <option value="{{$priority[$i]->id}}" >{{ucwords($priority[$i]->priority)}}</option>
                                    @endfor
                                </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Product Category <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" name="product_category"  class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" onchange="productA(this.value)" required>
                                <option value="0" selected="true">Select product category </option>
                                @for($i=0; $i < count($category); $i++ )
                                <option value="{{$category[$i]->id}}" >{{ucwords($category[$i]->fullname)}}</option>
                                @endfor
                               
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Product<span style="color: red">*</span></label>
                            <select    class="form-select " id="product" name="product_id"  required onchange="eFormType(this.value)" required>
                                <option value="" selected="true">Select product</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">E-Form Type<span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" name="e_form_type" class="form-select" id="e_form_type" required>
                                <option value="0" selected="true">Select E-Form Type</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Account Number </label>
                            <input type="text" class="form-control col-span-4" name="account_number" maxlength="16" placeholder="Account Number" onkeypress="return validateNumbers(event)" aria-label="default input inline 2">
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Card Number</label>
                            <select data-placeholder="Select your favorite actors" name="card_number" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                <option value="0" selected="true">Select Card Number</option>
                                <option value="1515121316513">1515121316513</option>

                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Card Title</label>
                            <input type="text" class="form-control col-span-4" name="card_title" placeholder="Card Title"  aria-label="default input inline 2">
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Customer Branch</label>
                            <select data-placeholder="Select your favorite actors" name="customer_branch_id" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                <option value="0" selected="true">Select  Branch</option>
                                @for($i=0; $i < count($unit); $i++ )
                                <option value="{{$unit[$i]->id}}" >{{ucwords($unit[$i]->unit_name)}} ({{$unit[$i]->branch_code}})</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Notes</label>
                            <textarea id="validation-form-6" class="form-control" onkeyup="validateAlphabetsAndNUumber(event)"  name="notes" maxlength='255'  placeholder="Additional Information" minlength="10" required=""></textarea>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Select File</label>
                            <input type="file" class="form-control col-span-4" name="file"  aria-label="default input inline 2">

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
                        <input type="text" class="form-control col-span-4 number" name="mobile_number" placeholder="92-xxxxxxxxxx" onkeypress="return validateNumbers(event)"  aria-label="default input inline 1" required>
                        </div>
                        <div>
                        <label for="regular-form-1" class="form-label">Telephone No (Office)</label>
                        <input type="text" class="form-control col-span-4 number" name="office_number" placeholder="92-xxxxxxxxxx" onkeypress="return validateNumbers(event)"  aria-label="default input inline 2">
                    </div>
                    <div class="">
                        <label for="regular-form-1" class="form-label">Residence Address <span style="color: red">*</span></label>
                        <textarea id="validation-form-6" class="form-control" onkeyup="validateAlphabetsAndNUumber(event)" maxlength='255' name="residence_address"  placeholder="Residence Address" minlength="10" required=""></textarea>
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
                            <input id="radio-switch-4" class="form-check-input" name="is_email" type="radio" checked value="1">
                            <label class="form-check-label" for="radio-switch-4">Yes</label>
                        </div>
                        <div class="form-check mr-2 mt-2 sm:mt-0">
                            <input id="radio-switch-5" class="form-check-input" name="is_email" type="radio"  value="0">
                            <label class="form-check-label" for="radio-switch-5">No</label>
                        </div>
                    </div>
                    </div>
                    <div>
                    <label for="regular-form-1" class="form-label">Customer E-Mail</label>
                    <div class="input-group">
                        <div id="input-group-email" class="input-group-text">@</div>
                        <input type="text" class="form-control" name="customer_e_mail" placeholder="abc@gmail.com" aria-label="Email" aria-describedby="input-group-email">
                    </div>
                </div>
                <div>
                    <label for="regular-form-1" class="form-label">SMS</label>
                    <div class="flex flex-col sm:flex-row mt-2">
                        <div class="form-check mr-2">
                            <input id="radio-switch-1" class="form-check-input" name="is_sms" type="radio" checked value="1">
                            <label class="form-check-label" for="radio-switch-1">Yes</label>
                        </div>
                        <div class="form-check mr-2 mt-2 sm:mt-0">
                            <input id="radio-switch-2" class="form-check-input" name="is_sms" type="radio"  value="0">
                            <label class="form-check-label" for="radio-switch-2">No</label>
                        </div>
                        
                    </div>
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Customer Mobile </label>
                        <input type="text" maxlength="12" class="form-control col-span-4 number" name="customer_mobile" placeholder="92-xxxxxxxxxx" onkeypress="return validateNumbers(event)"  aria-label="default input inline 1">
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Call Back</label>
                            <div class="flex flex-col sm:flex-row mt-2">
                                <div class="form-check mr-2">
                                    <input id="radio-switch-7" class="form-check-input" name="call_back" type="radio" checked value="1">
                                    <label class="form-check-label" for="radio-switch-7">Yes</label>
                                </div>
                                <div class="form-check mr-2 mt-2 sm:mt-0">
                                    <input id="radio-switch-8" class="form-check-input" name="call_back" type="radio"  value="0">
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
</form>
@push('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script> --}}
<script>
 
  function productA(val) {
        let value = {
            product_category_id: val,
        };
        $.ajax({
            type: 'GET',
            url: "{{ route('get_product_category_eform') }}",
            data: value,
            success: function(result) {
                document.getElementById('product').innerHTML =
                        '<option value="" selected="true">Select product</option>';
                    for (var i = 0; i < result.length; i++) {
                        var product = document.createElement('option');
                        product.value = result[i].id;
                        product.innerHTML = result[i].fullname;
                        document.getElementById('product').appendChild(product);
                    }
               
            }
        });
    }
    function eFormType(val)
    {
        let value = {
            product_id: val,
        };
        $.ajax({
            type: 'GET',
            url: "{{ route('get_e_form_type') }}",
            data: value,
            success: function(result) {
                console.log(result);
                
                document.getElementById('e_form_type').innerHTML =
                        '<option value="0" selected="true">Select E-Form Type</option>';
                    for (var i = 0; i < result.length; i++) {
                        var option = document.createElement('option');
                        option.value = result[i].id;
                        option.innerHTML = result[i].fullname;  
                        option.setAttribute('data-sub',result[i].is_subscription);
                        document.getElementById('e_form_type').appendChild(option);
                    }
               
            }
        });
    }
  
</script>
@endpush
    


@endsection
