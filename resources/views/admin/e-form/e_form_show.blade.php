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
    @if($data[0]->group_id == 0)
    <form id='e_form' method="POST" action="{{ route('e_form_edit',$data[0]->e_form_id) }}" >
    @else
    <form id='e_form' method="POST" action="{{ route('e_form_update_progress',$data[0]->e_form_id) }}" >
    @endif
    @csrf
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->
        <div class="intro-y box">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Entry Information
                </h2>
            </div>
            <div id="inline-form" class="p-5">
                <div class="preview">
                    <div class="grid grid-cols-12 gap-2">
                        <div>
                            <label for="regular-form-1" class="form-label">Groups <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" id="ddlGroup" name='group_id' class="form-select " {{$disable_info}} required>
                                <option value="" selected="true">Select Groups </option>
                                @for($i=0; $i < count($group); $i++)
                                <option value="{{$group[$i]->id}}" {{$data[0]->group_id == $group[$i]->id ? 'Selected' : ''}}>{{ucwords($group[$i]->group_name)}}</option>
                                @endfor
                            </select>
                            @if($errors->has('group_id'))
                            <div class="pristine-error text-danger mt-2" ><b>{{ $errors->first('group_id') }}</b></div>
                            @endif
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Branch(s) <span style="color: red">*</span></label>
                            @if($data[0]->unit_id != "0")
                            <select data-placeholder="Select your favorite actors"  id="ddlUnit" name='unit_id' {{$disable_info}}  class="form-select"  required>
                               
                                @for($i=0; $i < count($units); $i++)
                                    <option value="{{$units[$i]->id}}" {{$data[0]->unit_id== $units[$i]->id ? 'Selected' : ''}} >{{ucwords($units[$i]->unit_name)}} {{$units[$i]->branch_code}} ({{$units[$i]->branch_code}})</option>
                                @endfor
                            </select>
                            @else
                            <select class="form-select"  id="ddlUnit" name="unit_id" <?php echo $disable_info ?>>
                            </select>
                            @endif
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Is Approved</label>
                            <input id="show-example-3" data-target="#header" name="is_approved" value="1" {{$is_approved}} {{$approval_dis}} class="show-code form-check-input mr-0 ml-3" type="checkbox" >
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Source <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" name="source" class="form-select "  {{$disa}} {{$disable_user}} disabled>
                                @for($i=0; $i < count($source); $i++)
                                <option value="{{$source[$i]->id}}"  {{$data[0]->source == $source[$i]->id ? "selected" : ''}}>{{ucwords($source[$i]->source_name)}}</option>
                                @endfor
                            </select>
                        </div> 
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Progress <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite Progress" id="ddlProgress"  {{$disable_user}} {{$disa}} name="progress" class="form-select "  required>
                                <option value="0" disabled="disabled">Select Progress </option>
                                @php $start = $data[0]->progress > 0 ? 10 : 0; @endphp
                                @for($i = $start; $i <= 100; $i += 10)
                                <option value="{{$i}}" {{$data[0]->progress == $i ? "selected" : ""}}  >{{$i}} %</option>
                                @endfor
                                <option value="101">Duplicate</option>
                            </select>
                            @if($errors->has('progress'))
                            <div class="pristine-error text-danger mt-2" ><b>{{ $errors->first('progress') }}</b></div>
                            @endif
                        </div>   
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Activity Notes <span style="color: red">*</span></label>
                            <textarea id="validation-form-6" maxlength='255' class="form-control" name="activity_note" {{$disa}} {{$disable_user}} placeholder="Activity Notes" minlength="10" required></textarea>
                            @if($errors->has('activity_note'))
                            <div class="pristine-error text-danger mt-2" ><b>{{ $errors->first('activity_note') }}</b></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->

            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        E-form Details
                    </h2>
                </div>
             
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div>
                            <label for="regular-form-1" class="form-label">E-Form Num</label>
                            <input type="text" class="form-control col-span-4" {{$disabled}} value="{{$data[0]->eform_num}}" placeholder="E-Form Num" name="e_form_number" aria-label="default input inline 1">
                            </div>
                            <div>
                            <label for="regular-form-1" class="form-label">CNIC <span style="color: red">*</span></label>
                            <input type="text" id='cnic' name="cnic" {{$disabled}} value="{{$data[0]->cnic}}" class="form-control col-span-4" onkeypress="return validateNumbers(event);" placeholder="CNIC" aria-label="default input inline 2" required>
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Customer Name <span style="color: red">*</span></label>
                            <input type="text" name="customer_name" {{$disabled}} value="{{$data[0]->customer_name}}" class="form-control col-span-4" placeholder="Customer Name" onkeypress="return validateAlphabets(event);"  aria-label="default input inline 2" required>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Mother Maiden Name</label>
                            <input type="text" name="mother_maiden_name" {{$disabled}} value="{{$data[0]->mother_maiden}}" class="form-control col-span-4" placeholder="Mother Maiden Name" onkeypress="return validateAlphabets(event);"  aria-label="default input inline 1">
                            </div>
                            <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Date of Birth </label>
                            <div id="basic-datepicker">
                                <div class="preview">
                                    <input type="text" name="dob" {{$disabled}} value="{{$data[0]->dob}}" class="datepicker form-control  block mx-auto" onkeypress="return validateAlphabets(event);"  data-single-mode="true">
                                </div>
                               
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Priority</label>
                                <select data-placeholder="Select your favorite actors" {{$disabled}} name="priority" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="0" selected="true">Select priority </option>
                                    @for($i=0; $i < count($priority); $i++ )
                                    <option value="{{$priority[$i]->id}}" {{$data[0]->priority_id == $priority[$i]->id ? "Selected" : ''}}>{{ucwords($priority[$i]->priority)}}</option>
                                    @endfor
                                </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Product Category <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" {{$disabled}} name="product_category"  class="tom-select w-full tomselected" id="product_category" tabindex="-1" hidden="hidden" onchange="productA(this.value)" required>
                                <option value="0" selected="true">Select product category </option>
                                @for($i=0; $i < count($category); $i++ )
                                <option value="{{$category[$i]->id}}" {{$data[0]->product_category == $category[$i]->id ? "Selected" : ''}}>{{ucwords($category[$i]->fullname)}}</option>
                                @endfor
                               
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Product<span style="color: red">*</span></label>
                            <select    class="form-select " id="product" {{$disabled}} name="product_id"  required onchange="eFormType(this.value)" required>
                                <option value="" selected="true">Select product</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">E-Form Type<span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" {{$disabled}} name="e_form_type" class="form-select" id="e_form_type" required>
                                <option value="0" selected="true">Select E-Form Type</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Account Number </label>
                            <input type="text" class="form-control col-span-4" {{$disabled}} value="{{$data[0]->account_no}}" name="account_number" placeholder="Account Number" onkeypress="return validateNumbers(event)" aria-label="default input inline 2">
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Card Number</label>
                            <select data-placeholder="Select your favorite actors" {{$disabled}} name="card_number" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                <option value="0" selected="true">Select Card Number</option>
                                <option value="1515121316513" {{$data[0]->card_no == '1515121316513' ? "Selected" : ''}}>1515121316513</option>

                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Card Title</label>
                            <input type="text" class="form-control col-span-4" {{$disabled}} value="{{$data[0]->card_title}}" name="card_title" placeholder="Card Title"  aria-label="default input inline 2">
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Customer Branch</label>
                            <select data-placeholder="Select your favorite actors" {{$disabled}} name="customer_branch_id" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                <option value="0" selected="true">Select  Branch</option>
                                @for($i=0; $i < count($units); $i++ )
                                <option value="{{$units[$i]->id}}" {{$data[0]->customer_branch_id == $units[$i]->id ? "Selected" : ''}}>{{ucwords($units[$i]->unit_name)}} ({{$units[$i]->branch_code}})</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Notes</label>
                            <textarea id="validation-form-6" maxlength='255' class="form-control" {{$disabled}} name="description"  placeholder="Additional Information" minlength="10" required="">{{$data[0]->description}}</textarea>
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
                        <input type="text" class="form-control col-span-4 number" {{$disabled}} value="{{$data[0]->mobile_num}}" name="mobile_number" placeholder="92-xxxxxxxxxx" onkeypress="return validateNumbers(event)"  aria-label="default input inline 1" required>
                        </div>
                        <div>
                        <label for="regular-form-1" class="form-label">Telephone No (Office)</label>
                        <input type="text" class="form-control col-span-4 number " {{$disabled}} value="{{$data[0]->office_num}}" name="office_number" placeholder="92-xxxxxxxxxx" onkeypress="return validateNumbers(event)"  aria-label="default input inline 2">
                    </div>
                    <div class="">
                        <label for="regular-form-1" class="form-label">Residence Address <span style="color: red">*</span></label>
                        <textarea id="validation-form-6" maxlength='255' class="form-control" {{$disabled}} value="{{$data[0]->residence_address}}" name="residence_address"  placeholder="Residence Address" minlength="10" required=""></textarea>
                    </div>
                    
                    </div>
                </div>
            </div>
       
    </div>
    </div>
</form>
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
                            <input id="radio-switch-4" class="form-check-input" name="is_email" {{$disabled}} type="radio" {{$data[0]->is_email == '1' ? 'checked' : ''}}  value="1">
                            <label class="form-check-label" for="radio-switch-4">Yes</label>
                        </div>
                        <div class="form-check mr-2 mt-2 sm:mt-0">
                            <input id="radio-switch-5" class="form-check-input" name="is_email" {{$disabled}} type="radio" {{$data[0]->is_email == '1' ? 'checked' : ''}}  value="0">
                            <label class="form-check-label" for="radio-switch-5">No</label>
                        </div>
                    </div>
                    </div>
                    <div>
                    <label for="regular-form-1" class="form-label">Customer E-Mail</label>
                    <div class="input-group">
                        <div id="input-group-email" class="input-group-text">@</div>
                        <input type="text" class="form-control" name="customer_e_mail" {{$disabled}} value="{{$data[0]->customer_email}}" placeholder="abc@gmail.com" aria-label="Email" aria-describedby="input-group-email">
                    </div>
                </div>
                <div>
                    <label for="regular-form-1" class="form-label">SMS</label>
                    <div class="flex flex-col sm:flex-row mt-2">
                        <div class="form-check mr-2">
                            <input id="radio-switch-1" class="form-check-input" name="is_sms" {{$disabled}} type="radio" {{$data[0]->is_sms == '1' ? 'checked' : ''}} value="1">
                            <label class="form-check-label" for="radio-switch-1">Yes</label>
                        </div>
                        <div class="form-check mr-2 mt-2 sm:mt-0">
                            <input id="radio-switch-2" class="form-check-input" name="is_sms" {{$disabled}} type="radio" {{$data[0]->is_sms == '1' ? 'checked' : ''}}  value="0">
                            <label class="form-check-label" for="radio-switch-2">No</label>
                        </div>
                        
                    </div>
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Customer Mobile </label>
                        <input type="text" maxlength="12" class="form-control col-span-4 number" {{$disabled}} value="{{$data[0]->customer_mobile_num}}" name="customer_mobile" placeholder="92-xxxxxxxxxx" onkeypress="return validateNumbers(event)"  aria-label="default input inline 1">
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Call Back</label>
                            <div class="flex flex-col sm:flex-row mt-2">
                                <div class="form-check mr-2">
                                    <input id="radio-switch-7" class="form-check-input" {{$disabled}} name="call_back" {{$data[0]->is_call_back == '1' ? 'checked' : ''}} type="radio" checked value="1">
                                    <label class="form-check-label" for="radio-switch-7">Yes</label>
                                </div>
                                <div class="form-check mr-2 mt-2 sm:mt-0">
                                    <input id="radio-switch-8" class="form-check-input" {{$disabled}} name="call_back" {{$data[0]->is_call_back == '1' ? 'checked' : ''}} type="radio"  value="0">
                                    <label class="form-check-label" for="radio-switch-8">No</label>
                                </div>
                                
                            </div>
                            </div>
                </div>
                <button type="submit" class="btn btn-primary mt-5" {{$dis_button}}>{{$button}}</button>

            </div>
        </div>
   
</div>
</div>
<div class="intro-y box mt-5 col-span-12 lg:col-span-6">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <ul class="nav nav-boxed-tabs" role="tablist">
            <li id="example-1-tab" class="nav-item flex-1" role="presentation">
                <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-1" type="button" role="tab" aria-controls="example-tab-3" aria-selected="true">E-Form Activities</button>
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
                                        <th class="whitespace-nowrap">Date / Time</th>
                                        <th class="whitespace-nowrap">Previous State</th>
                                        <th class="whitespace-nowrap">Current State</th>
                                        <th class="whitespace-nowrap">Activity Performer (User)</th>
                                        <th class="whitespace-nowrap">Comments</th>
                                        <th class="whitespace-nowrap">Assigned To</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i=0; $i < count($activityData); $i++)
                                    @php
                                     $status = "";
                                        if($activityData[$i]->current_state == 1){
                                            $currStatus = "Initiated";
                                            $preStatus  = "Initiated";
                                        }

                                        elseif($activityData[$i]->current_state == 2 && $activityData[$i]->progress > 0){
                                            $currStatus = "In Progress";
                                            $preStatus  = "In Progress";
                                        }

                                        /*elseif($row["current_state"] == 2 && $row["progress"] == 0){
                                            $currStatus = "In Progress";
                                            $preStatus  = "In Progress";
                                        }*/

                                        elseif($activityData[$i]->current_state == 2){
                                            $currStatus = "In Progress";
                                            $preStatus  = "Initiated";
                                        }
                                        elseif($activityData[$i]->current_state == 3){
                                            $currStatus = "Closed";
                                            $preStatus  = "In Progress";
                                        }
                                        elseif($activityData[$i]->current_state == 4){
                                            $currStatus = "Verified";
                                            $preStatus  = "Closed";
                                        }
                                        elseif($activityData[$i]->current_state == 5) {
                                            $currStatus = "Duplicate";
                                            $preStatus = "Forwarded";
                                        }
                                    @endphp
                                    <tr class="intro-x">
                                        <td class="text-left ">{{$activityData[$i]->update_datetime}}</td>
                                        <td class="text-left">{{ucfirst($preStatus)}}</td>
                                        <td class="text-left">{{ucfirst($currStatus)}}</td>
                                        <td class="text-left">{{$activityData[$i]->activity_performer}}</td>
                                        <td class="text-left">{{$activityData[$i]->comments}}</td>
                                        @php
                                            $assignTo=App\Http\Controllers\ComplaintManagementController::GetUserUnitForComplaint($activityData[$i]->assign_to);
                                        @endphp
                                        <td class="text-left ">{{$assignTo[0]->unit_name}}</td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@push('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script> --}}
<script>

 productA($('#product_category').val()) 
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
                        if (result[i].id == "{{ $data[0]->product_id }}") product.defaultSelected =
                        true;
                        document.getElementById('product').appendChild(product);
                    }
               
            }
        });
    }
    eFormType($('#product_id').val()) 

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
                        if (result[i].id == "{{ $data[0]->eform_type_id }}") option.defaultSelected =
                        true;
                        document.getElementById('e_form_type').appendChild(option);
                    }
               
            }
        });
    }
    $(document).on('change', '#ddlGroup', function () {

        var group = $(this).val();

        $.ajax({
            type: "Get",
            url: "{{ route('get_unit_groups') }}",
            data:{
                group  : group,
                is_all : 0
            }
        }).done(function (data) {
            //console.log(data);
            $('#ddlUnit').html(data);
        });

        });
</script>
@endpush
    


@endsection
