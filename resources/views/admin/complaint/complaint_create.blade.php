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
            Complaint Management
        </h2>
    </div>
    <form id='complaint_form' method="POST" action="{{ route('complaint_create') }}" >
        @csrf
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Add Complaint
                    </h2>
                </div>
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div>
                            <label for="regular-form-1" class="form-label">Complaint Lodge By</label>
                            <input type="text" class="form-control col-span-4" name="complaint_lodge_by" placeholder="Complaint Lodge By" aria-label="default input inline 1" value="{{Session::get('user_name')}}" readonly>
                            </div>
                            <div>
                            <label for="regular-form-1" class="form-label">Complaint Title <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" name="complaint_title" placeholder="Complaint Title" aria-label="default input inline 2" required>
                            </div>
                            <div>
                                <label for="regular-form-1" class="form-label">CNIC <span style="color: red">*</span></label>
                                <input type="text" id="cnic" class="form-control col-span-4" name="cnic" placeholder="42201-XXXXXXX-X" aria-label="default input inline 2" required>
                                </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Customer Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" name="customer_name" placeholder="Customer Name" aria-label="default input inline 2" required>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Mother Maiden Name</label>
                            <input type="text" class="form-control col-span-4" name="mother_maiden_name" placeholder="Mother Maiden Name" aria-label="default input inline 1">
                            </div>
                            <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Date of Birth </label>
                            <div id="basic-datepicker">
                                <div class="preview">
                                    <input type="text" name="date_of_birth" class="datepicker form-control  block mx-auto" data-single-mode="true">
                                </div>
                               
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Product Category <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" name='product_category' class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" onchange="productB(this.value)" required>
                                <option value="0" selected="true">Select product Category </option>
                                @for($i=0; $i < count($complaintCategory); $i++)
                                <option value="{{$complaintCategory[$i]->id}}" >{{ucwords($complaintCategory[$i]->fullname)}}</option>
                                @endfor
                                
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Product <span style="color: red">*</span></label>
                            <select  name="product" class="form-select " id="product"  required onchange="complaintType(this.value)">
                                <option value="0" selected="true">Select product</option>
                            
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Complaint Type <span style="color: red">*</span> <span id="tatDisplay" style="display:none;"> <b> (TAT: 7 Days) </b> </span></label>
                            <select  name="complaint_type" id="complaint_type" class="form-select "   required>
                                <option value="0" selected="true">Select Complaint Type</option>
                              
                                
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Priority </label>
                            <select data-placeholder="Select your favorite actors" name="priority" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                <option value="0" selected="true">Select Priority</option>
                                @for($i=0; $i < count($priority); $i++)
                                <option value="{{$priority[$i]->id}}" >{{ucwords($priority[$i]->priority)}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Card Numbers <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4"  maxlength="16" name="card_number" onkeypress="return validateNumbers(event)" placeholder="Card Numbers" aria-label="default input inline 1" required>

                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Complaint Nature </label>
                            <select data-placeholder="Select your favorite actors" name="complaint_nature" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                <option value="Complaint" selected="selected">Complaint</option>
                                <option value="Lead">Lead</option>
                                <option value="Suggestion">Suggestion</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Customer Branch <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" name="customer_branch" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" required>
                                <option value="0" selected="true">Select Customer Branch</option>
                                @for($i=0; $i < count($branch); $i++)
                                <option value="{{$branch[$i]->id}}" >{{ucwords($branch[$i]->unit_name)}} ( {{$branch[$i]->branch_code}} )</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Complaint Against Branch <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" name="complaint_against_branch" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" required>
                                <option value="0" selected="true">Select Complaint Against Branch</option>
                                @for($i=0; $i < count($branch); $i++)
                                <option value="{{$branch[$i]->id}}" >{{ucwords($branch[$i]->unit_name)}} ( {{$branch[$i]->branch_code}} )</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Channel </label>
                            <select data-placeholder="Select your favorite actors" name="channel" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                @for($i=0; $i < count($channel); $i++)
                                <option value="{{$channel[$i]->id}}" {{ $channel[$i]->id == 3 ? 'Selected' : ''}} >{{ucwords($channel[$i]->fullname)}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Source <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" name="source" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" required>
                                <option value="0" selected="true">Select Source</option>
                                @for($i=0; $i < count($source); $i++)
                                <option value="{{$source[$i]->id}}"  >{{ucwords($source[$i]->source_name)}}</option>
                                @endfor
                            </select>
                        </div>  
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Notes</label>
                            <textarea id="validation-form-6" class="form-control" onkeyup="validateAlphabetsAndNUumber(event)" name="note" maxlength='255' placeholder="Additional Information" minlength="10" required=""></textarea>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Language  <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors"  name="language" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" required>
                                @for($i=0; $i < count($language); $i++)
                                <option value="{{$language[$i]->id}}"  >{{ucwords($language[$i]->fullname)}}</option>
                                @endfor
                            </select>
                        </div>  
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Amount </label>
                            <input type="text" class="form-control col-span-4"  name="amount" placeholder="Amount" onkeypress="return validateNumbers(event)" aria-label="default input inline 1">

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
                    Call Back Information
                </h2>
            </div>
            <div id="inline-form" class="p-5">
                <div class="preview">
                    <div class="grid grid-cols-12 gap-2">
                        <div>
                        <label for="regular-form-1" class="form-label">Call Back Phone <span style="color: red">*</span></label>
                        <input type="text" class="form-control col-span-4 number" name="call_back_phone" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" required>
                        </div>
                        <div>
                        <label for="regular-form-1" class="form-label">Phone Office</label>
                        <input type="text" class="form-control col-span-4 number" name="phone_office" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 2">
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Residence Address <span style="color: red">*</span></label>
                        <textarea id="validation-form-6" class="form-control" onkeyup="validateAlphabetsAndNUumber(event)" maxlength='255' name="residence_address" placeholder="Residence Address" minlength="10" required></textarea>
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
                            <input id="radio-switch-4" class="form-check-input" type="radio" name="e_mail" value="1" checked>
                            <label class="form-check-label" for="radio-switch-4">Yes</label>
                        </div>
                        <div class="form-check mr-2 mt-2 sm:mt-0">
                            <input id="radio-switch-5" class="form-check-input" type="radio" name="e_mail" value="0">
                            <label class="form-check-label" for="radio-switch-5">No</label>
                        </div>
                    </div>
                    </div>
                    <div>
                    <label for="regular-form-1" class="form-label">Customer E-Mail</label>
                    <div class="input-group">
                        <div id="input-group-email" class="input-group-text">@</div>
                        <input type="email" class="form-control" placeholder="abc@gmail.com" name="customer_e_mail" aria-label="Email" aria-describedby="input-group-email">
                    </div>
                </div>
                <div>
                    <label for="regular-form-1" class="form-label">SMS</label>
                    <div class="flex flex-col sm:flex-row mt-2">
                        <div class="form-check mr-2">
                            <input id="radio-switch-1" class="form-check-input" type="radio" name="sms" value="1" checked>
                            <label class="form-check-label" for="radio-switch-1">Yes</label>
                        </div>
                        <div class="form-check mr-2 mt-2 sm:mt-0">
                            <input id="radio-switch-2" class="form-check-input" type="radio" name="sms" value="0">
                            <label class="form-check-label" for="radio-switch-2">No</label>
                        </div>
                        
                    </div>
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Customer Mobile </label>
                        <input type="text" class="form-control col-span-4 number" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1">
                        </div>
                        
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Call Back</label>
                            <div class="flex flex-col sm:flex-row mt-2">
                                <div class="form-check mr-2">
                                    <input id="radio-switch-7" class="form-check-input" type="radio" name="call_back" value="1" checked>
                                    <label class="form-check-label" for="radio-switch-7">Yes</label>
                                </div>
                                <div class="form-check mr-2 mt-2 sm:mt-0">
                                    <input id="radio-switch-8" class="form-check-input" type="radio" name="call_back" value="0">
                                    <label class="form-check-label" for="radio-switch-8">No</label>
                                </div>
                                
                            </div>
                            </div>
                </div>
                <button type="button" onclick="complaintAdd()" class="btn btn-primary mt-5">Save</button>

            </div>
        </div>
   
</div>
</div>
</form>
</div>

@push('scripts')
<script>
    function complaintAdd() {
        
        $.ajax({
                url: $("#complaint_form").attr('action'),
                method: 'POST',
                data: $('#complaint_form').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
            success: function(result) {
                if(result == 'insert')
                {
                    let url = "{{ route('complaint_index') }}";
                        document.location.href=url;
                }
                else
                {
                    myModal = tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview"));
                    $('#myModalLgHeading').html('Duplicate Data');
                    $('#modalBodyLarge').html(result);
                    myModal.show();
                }
               
            }
        });
    }

   function productB(val) {
        let value = {
            product_category_id: val,
        };
        $.ajax({
            type: 'GET',
            url: "{{ route('get_product_category') }}",
            data: value,
            success: function(result) {
                console.log(result);
                
                document.getElementById('product').innerHTML =
                        '<option value="0" selected="true">Select product</option>';
                    for (var i = 0; i < result.length; i++) {
                        var product = document.createElement('option');
                        product.value = result[i].id;
                        product.innerHTML = result[i].fullname;
                        document.getElementById('product').appendChild(product);
                    }
               
            }
        });
    }
    function complaintType(val)
    {
        let value = {
            product_id: val,
        };
        $.ajax({
            type: 'GET',
            url: "{{ route('get_complaint_type') }}",
            data: value,
            success: function(result) {
                console.log(result);
                
                document.getElementById('complaint_type').innerHTML =
                        '<option value="0" selected="true">Select Complaint Type</option>';
                    for (var i = 0; i < result.length; i++) {
                        var option = document.createElement('option');
                        option.value = result[i].id;
                        option.innerHTML = result[i].fullname;  
                        option.setAttribute('data-tat',result[i].tat);
                        document.getElementById('complaint_type').appendChild(option);
                    }
               
            }
        });
    }
        $(document).on('change', '#complaint_type', function () {
            
            var tat_value = $('option:selected', this).attr('data-tat');
            
            $("#tatDisplay").html('<b> (TAT: ' + tat_value +' Days) </b>');
            $("#tatDisplay").show();
            
        });

  </script>
@endpush

@endsection
