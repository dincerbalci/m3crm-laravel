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
    @if($complaint[0]->group_id == 0)
    <form id='complaint_form' method="POST" action="{{ route('complaint_edit',$complaint[0]->complaint_id) }}" >
    @else
    <form id='complaint_form' method="POST" action="{{ route('update_progress',$complaint[0]->complaint_id) }}" >
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
                                <select data-placeholder="Select your favorite actors" {{$disable_info}} id="ddlGroup" name='group_id' class="form-select " required>
                                    <option value="" selected="true">Select Groups </option>
                                    @for($i=0; $i < count($group); $i++)
                                    <option value="{{$group[$i]->id}}" {{$complaint[0]->group_id == $group[$i]->id ? 'Selected' : ''}}>{{ucwords($group[$i]->group_name)}}</option>
                                    @endfor
                                </select>
                                @if($errors->has('group_id'))
                                <div class="pristine-error text-danger mt-2" ><b>{{ $errors->first('group_id') }}</b></div>
                                @endif
                            </div>
                            <div>
                                <label for="regular-form-1" class="form-label">Assign To <span style="color: red">*</span></label>
                                @if($complaint[0]->unit_id != "0")
                                <select data-placeholder="Select your favorite actors" id="ddlUnit" name='unit_id' {{$disable_info}}  class="form-select"  required>
                                    <option value="0" selected="true">Select Groups </option>
                                    @php $counter = 0; 
                                    $unitIds =  explode(",",$complaint[0]->unit_id);
                                 
                                     @endphp
                                    @for($i=0; $i < count($units); $i++)
                                    <option value="{{$units[$i]->id}}" {{($unitIds[$counter] == $units[$i]->id ? "selected" : '')}}>{{ucwords($units[$i]->unit_name)}} ( {{$units[$i]->branch_code}} )</option>
                                   
                                    @endfor
                                </select>
                                @if($errors->has('unit_id'))
                                <div class="pristine-error text-danger mt-2" ><b>The Assign To field is required.</b></div>
                                @endif
                                @else
                                <select class="form-select" {{$disable_info}} id="ddlUnit" name='unit_id'>
                                    <option value="" selected="selected" >Select Assignee</option>
                                </select>
                                @if($errors->has('unit_id'))
                                <div class="pristine-error text-danger mt-2" ><b>{{ $errors->first('unit_id') }}</b></div>
                                @endif
                                @endif
                            </div>
                            <div>
                                <label for="regular-form-1" class="form-label">Complaint Lodge By</label>
                                <input type="text" class="form-control col-span-4" name="complaint_lodge_by" value="{{$complaint[0]->branch_code != "" ?  " ".$complaint[0]->unit_name." (".$complaint[0]->branch_code.")" : ".".$complaint[0]->unit_name."." }}" placeholder="Complaint Lodge By" aria-label="default input inline 1"  readonly>
                            </div>
                            <div class="mt-3">
                                <label for="regular-form-1" class="form-label">Source <span style="color: red">*</span></label>
                                <select data-placeholder="Select your favorite actors" name="source" class="form-select "  readonly>
                                    <option value="0" selected="true">Select Source {{$complaint[0]->source}}</option>
                                    @for($i=0; $i < count($source); $i++)
                                    <option value="{{$source[$i]->id}}"  {{$complaint[0]->source == $source[$i]->id ? "selected" : ''}}>{{ucwords($source[$i]->source_name)}}</option>
                                    @endfor
                                </select>
                            </div> 
                            <div class="mt-3">
                                <label for="regular-form-1" class="form-label">Progress <span style="color: red">*</span></label>
                                <select data-placeholder="Select your favorite Progress" id="ddlProgress" {{($complaint[0]->progress == 0 && $complaint[0]->unit_id == 0) ? "disabled" : ""}} {{$disable_user}} name="progress" class="form-select "  required>
                                    <option value="0" disabled="disabled">Select Progress </option>
                                    @php $start = $complaint[0]->progress > 0 ? 10 : 0; @endphp
                                    @for($i = $start; $i <= 100; $i += 10)
                                    <option value="{{$i}}" {{$complaint[0]->progress == $i ? "selected" : ""}} {{($i == 100 && $userType != 2) ? "disabled" : ""}}  {{($complaint[0]->progress > $i && $userType != 2) ? "disabled" : ""}}>{{$i}} %</option>
                                    @endfor
                                </select>
                                @if($errors->has('progress'))
                                <div class="pristine-error text-danger mt-2" ><b>{{ $errors->first('progress') }}</b></div>
                                @endif
                            </div>   
                            <div class="mt-3">
                                <label for="regular-form-1" class="form-label">Activity Notes <span style="color: red">*</span></label>
                                <textarea id="validation-form-6" class="form-control" name="activity_note" {{$disable_user}} placeholder="Activity Notes" minlength="10" required></textarea>
                                @if($errors->has('activity_note'))
                                <div class="pristine-error text-danger mt-2" ><b>{{ $errors->first('activity_note') }}</b></div>
                                @endif
                            </div>
                            <div class="mt-3" id="favorDiv" style="display: {{($complaint[0]->progress >= 90 && $userType == 2) ? 'block' : 'none'}}">
                                <label for="regular-form-1" class="form-label">Favor <span style="color: red">*</span></label>
                                <select data-placeholder="Select your favorite favor"  name="favor" class="form-select "  required {{$disable_user}}>
                                    @for($i = 0; $i < count($favor); $i++)
                                    <option value="{{$favor[$i]->id}}" {{($complaint[0]->favor == $favor[$i]->id ? "selected='selected'": '')}} >{{ucwords($favor[$i]->fullname)}} </option>
                                    @endfor
                                </select>
                                @if($errors->has('favor'))
                                <div class="pristine-error text-danger mt-2" ><b>{{ $errors->first('favor') }}</b></div>
                                @endif
                            </div>
                            <div class="mt-3" id="closeNoteDiv" style="display: {{($complaint[0]->progress >= 90 && $userType == 2) ? 'block' : 'none'}}">
                                <label>Close Notes<span style="color: red;">*</span></label>
                                <textarea type="text" class="form-control" maxlength="255" id="txtCloseNotes" name="close_notes" rows="4" placeholder="Close Notes" dir="{{$complaint[0]->language == 1 ? 'ltr' : 'rtl'}}" {{$disable_user}}>{{$complaint[0]->close_notes}}</textarea>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Close Notes is required</div>
                                <small id="count">Characters left: <b>0/255</b></small>
                                @if($errors->has('close_notes'))
                                <div class="pristine-error text-danger mt-2" ><b>{{ $errors->first('close_notes') }}</b></div>
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
                        Complaint
                    </h2>
                </div>
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div>
                                <label for="regular-form-1" class="form-label">Complaint Number </label>
                                <input type="text" class="form-control col-span-4" {{$disabled}} value="{{$complaint[0]->complaint_num}}" name="complaint_title" placeholder="Complaint Title" aria-label="default input inline 2" >
                                </div>
                            <div>
                            <label for="regular-form-1" class="form-label">Complaint Title </label>
                            <input type="text" class="form-control col-span-4" {{$disabled}} value="{{$complaint[0]->compl_title}}" name="complaint_title" placeholder="Complaint Title" aria-label="default input inline 2" >
                            </div>
                            <div>
                                <label for="regular-form-1" class="form-label">CNIC </label>
                                <input type="text" id="cnic" class="form-control col-span-4" {{$disabled}} value="{{$complaint[0]->cnic}}" name="cnic" placeholder="42201-XXXXXXX-X" aria-label="default input inline 2" required>
                                </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Customer Name </label>
                            <input type="text" class="form-control col-span-4" {{$disabled}} name="customer_name"  value="{{$complaint[0]->customer_name}}" placeholder="Customer Name" aria-label="default input inline 2" required>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Mother Maiden Name</label>
                            <input type="text" class="form-control col-span-4" {{$disabled}} name="mother_maiden_name"  value="{{$complaint[0]->mother_maiden}}" placeholder="Mother Maiden Name" aria-label="default input inline 1">
                            </div>
                            <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Date of Birth </label>
                            <div id="basic-datepicker">
                                <div class="preview">
                                    <input type="text" name="date_of_birth" {{$disabled}} value="{{$complaint[0]->dob}}" class="datepicker form-control  block mx-auto" data-single-mode="true">
                                </div>
                               
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Product Category <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors"  id='product_category' {{$disabled_types}} name='product_category'  class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" onchange="productB(this.value)" required>
                                <option value="0" selected="true">Select product Category </option>
                                @for($i=0; $i < count($complaintCategory); $i++)
                                <option value="{{$complaintCategory[$i]->id}}"  {{$complaintCategory[$i]->id == $complaint[0]->product_category ? 'Selected' : ''}} >{{ucwords($complaintCategory[$i]->fullname)}}</option>
                                @endfor
                                @if($errors->has('product_category'))
                                <div class="pristine-error text-danger mt-2" ><b>{{ $errors->first('product_category') }}</b></div>
                                @endif
                                
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Product <span style="color: red">*</span></label>
                            <select  name="product" class="form-select " id="product" {{$disabled_types}} required onchange="complaintType(this.value)">
                                <option value="0" selected="true">Select product</option>
                            </select>
                            @if($errors->has('product'))
                            <div class="pristine-error text-danger mt-2" ><b>{{ $errors->first('product') }}</b></div>
                            @endif
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Complaint Type <span style="color: red">*</span> <span id="tatDisplay" style="display:none;"> <b> (TAT: 7 Days) </b> </span></label>
                            <select  name="complaint_type" id="complaint_type" {{$disabled_types}}  class="form-select "   required>
                                <option value="0" selected="true">Select Complaint Type</option>
                            </select>
                            @if($errors->has('complaint_type'))
                            <div class="pristine-error text-danger mt-2" ><b>{{ $errors->first('complaint_type') }}</b></div>
                            @endif
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Priority </label>
                            <select data-placeholder="Select your favorite actors" {{$disabled}} name="priority" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                <option value="0" selected="true">Select Priority</option>
                                @for($i=0; $i < count($priority); $i++)
                                <option value="{{$priority[$i]->id}}" {{$complaint[0]->priority_id == $priority[$i]->id ? "selected" : ""}}>{{ucwords($priority[$i]->priority)}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Card Numbers <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" {{$disabled}} value="{{$complaint[0]->account_no}}" name="card_number" onkeypress="return validateNumbers(event)" placeholder="Card Numbers" aria-label="default input inline 1" required>

                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Complaint Nature </label>
                            <select data-placeholder="Select your favorite actors" {{$disabled}}  name="complaint_nature" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                <option value="Complaint" {{$complaint[0]->complaint_nature == 'Complaint' ? 'Selected' : ''}}>Complaint</option>
                                <option value="Lead" {{$complaint[0]->complaint_nature == 'Lead' ? 'Selected' : ''}}>Lead</option>
                                <option value="Suggestion" {{$complaint[0]->complaint_nature == 'Suggestion' ? 'Selected' : ''}}>Suggestion</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Customer Branch <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" {{$disabled_types}} name="customer_branch" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" required>
                                <option value="0" selected="true">Select Customer Branch</option>
                                @for($i=0; $i < count($branch); $i++)
                                <option value="{{$branch[$i]->id}}" {{$complaint[0]->customer_branch_id == $branch[$i]->id ? 'Selected' : ''}}>{{ucwords($branch[$i]->unit_name)}} ( {{$branch[$i]->branch_code}} )</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Complaint Against Branch <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" {{$disabled}}  name="complaint_against_branch" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" required>
                                <option value="0" selected="true">Select Complaint Against Branch</option>
                                @for($i=0; $i < count($branch); $i++)
                                <option value="{{$branch[$i]->id}}" {{ $complaint[0]->against_branch_id == $branch[$i]->id ? "selected": ''}}>{{ucwords($branch[$i]->unit_name)}} ( {{$branch[$i]->branch_code}} )</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Channel </label>
                            <select data-placeholder="Select your favorite actors" {{$disabled}} name="channel" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                @for($i=0; $i < count($channel); $i++)
                                <option value="{{$channel[$i]->id}}" {{ $complaint[0]->channel == $channel[$i]->id ? "selected": ''}} >{{ucwords($channel[$i]->fullname)}}</option>
                                @endfor
                            </select>
                        </div>
                       
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Notes</label>
                            <textarea id="validation-form-6" class="form-control" {{$disabled}} name="note" placeholder="Additional Information" minlength="10"  required="">{{$complaint[0]->description}}</textarea>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Comments</label>
                            <textarea id="validation-form-6" class="form-control" {{$disabled}} name="note" placeholder="Comments" minlength="10"  required="">{{$complaint[0]->comments}}</textarea>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Language  <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" {{$disabled}}  name="language" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" required>
                                @for($i=0; $i < count($language); $i++)
                                <option value="{{$language[$i]->id}}" {{$complaint[0]->language == $language[$i]->id ? "selected": ''}} >{{ucwords($language[$i]->fullname)}}</option>
                                @endfor
                            </select>
                        </div>  
                        
                        </div>
                        
                    <fieldset >

                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Amount </label>
                        <input type="text" class="form-control col-span-4" {{$disabled_types}}  name="amount" value="{{$complaint[0]->amount}}" placeholder="Amount" onkeypress="return validateNumbers(event)" aria-label="default input inline 1">

                    </div>
                    </fieldset>
                    </div>
                   
                </div>
           
        </div>

    </div>
    <div class="intro-y col-span-12 lg:col-span-6">
        <!-- BEGIN: Input -->
        <fieldset {{$disabled}}>
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
                        <input type="text" class="form-control col-span-4 number"  value="{{$complaint[0]->callback_num}}" name="call_back_phone" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" required>
                        </div>
                        <div>
                        <label for="regular-form-1" class="form-label">Phone Office</label>
                        <input type="text" class="form-control col-span-4 number"  value="{{$complaint[0]->office_phone}}" name="phone_office" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 2">
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Residence Address <span style="color: red">*</span></label>
                        <textarea id="validation-form-6" class="form-control"   name="residence_address" placeholder="Residence Address" minlength="10" required>{{$complaint[0]->residence_address}}</textarea>
                    </div>
                    
                    </div>
                </div>
            </div>
       
    </div>
        </fieldset>
   
    
 

<div class="intro-y col-span-12 lg:col-span-6 mt-5">
    <!-- BEGIN: Input -->
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
                Acknowledge Response
            </h2>
        </div>
        <div id="inline-form" class="p-5">
            <div class="preview">
                <fieldset {{$disabled}}>
                <div class="grid grid-cols-12 gap-2">
                    <div>
                    <label for="regular-form-1" class="form-label">E-Mail</label>
                    <div class="flex flex-col sm:flex-row mt-2">
                        <div class="form-check mr-2">
                            <input id="radio-switch-4" class="form-check-input" type="radio" name="e_mail" value="1" {{$complaint[0]->is_email == '1' ? "checked" : ''}} >
                            <label class="form-check-label" for="radio-switch-4">Yes</label>
                        </div>
                        <div class="form-check mr-2 mt-2 sm:mt-0">
                            <input id="radio-switch-5" class="form-check-input" type="radio" name="e_mail" value="0" {{$complaint[0]->is_email == '0' ? "checked" : ''}}>
                            <label class="form-check-label" for="radio-switch-5">No</label>
                        </div>
                    </div>
                    </div>
                    <div>
                    <label for="regular-form-1" class="form-label">Customer E-Mail</label>
                    <div class="input-group">
                        <div id="input-group-email" class="input-group-text">@</div>
                        <input type="email" class="form-control" placeholder="abc@gmail.com" name="customer_e_mail" value="{{$complaint[0]->customer_email}}" aria-label="Email" aria-describedby="input-group-email">
                    </div>
                </div>
                <div>
                    <label for="regular-form-1" class="form-label">SMS</label>
                    <div class="flex flex-col sm:flex-row mt-2">
                        <div class="form-check mr-2">
                            <input id="radio-switch-1" class="form-check-input" type="radio" name="sms" value="1" {{$complaint[0]->is_sms == '1' ? "checked" : ''}}>
                            <label class="form-check-label" for="radio-switch-1">Yes</label>
                        </div>
                        <div class="form-check mr-2 mt-2 sm:mt-0">
                            <input id="radio-switch-2" class="form-check-input" type="radio" name="sms" value="0" {{$complaint[0]->is_sms == '0' ? "checked" : ''}}>
                            <label class="form-check-label" for="radio-switch-2">No</label>
                        </div>
                        
                    </div>
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Customer Mobile </label>
                        <input type="text" class="form-control col-span-4 number" name="customer_mobile" value="{{$complaint[0]->response_number }}" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1">
                        </div>
                        
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Call Back</label>
                            <div class="flex flex-col sm:flex-row mt-2">
                                <div class="form-check mr-2">
                                    <input id="radio-switch-7" class="form-check-input" type="radio" name="call_back" value="1" {{$complaint[0]->is_call_back == '1' ? "checked" : ''}}>
                                    <label class="form-check-label" for="radio-switch-7">Yes</label>
                                </div>
                                <div class="form-check mr-2 mt-2 sm:mt-0">
                                    <input id="radio-switch-8" class="form-check-input" type="radio" name="call_back" value="0" {{$complaint[0]->is_call_back == '0' ? "checked" : ''}}>
                                    <label class="form-check-label" for="radio-switch-8">No</label>
                                </div>
                                
                            </div>
                            </div>
                </div>
            </fieldset>
                <button type="submit" {{ $dis_button }} class="btn btn-primary mt-5">{{$button }}</button>

            </div>
        </div>
   
</div>
</div>
</form>
<div class="intro-y box mt-5 col-span-12 lg:col-span-6">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <ul class="nav nav-boxed-tabs" role="tablist">
            <li id="example-1-tab" class="nav-item flex-1" role="presentation">
                <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-1" type="button" role="tab" aria-controls="example-tab-3" aria-selected="true">Complaint Activities</button>
            </li>
            <li id="example-2-tab" class="nav-item flex-1" role="presentation">
                <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-2" type="button" role="tab" aria-controls="example-tab-4" aria-selected="false">SMS Activities</button>
            </li>
            <li id="example-3-tab" class="nav-item flex-1" role="presentation">
                <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-3" type="button" role="tab" aria-controls="example-tab-4" aria-selected="false">Email Escalation</button>
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
                                    <tr class="intro-x">
                                        <td class="text-left ">{{$activityData[$i]->update_datetime}}</td>
                                        <td class="text-left">{{ucfirst($activityData[$i]->previous_state_name)}}</td>
                                        <td class="text-left">{{ucfirst($activityData[$i]->current_state_name)}}</td>
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
                <div id="example-tab-2" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-2-tab" style=""> 
                    <div class="overflow-x-auto scrollbar-hidden">
                        <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                            <table class="table table-report sm:mt-2">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">Date / Time</th>
                                        <th class="whitespace-nowrap">Number</th>
                                        <th class="whitespace-nowrap">SMS</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i=0; $i < count($smsDetails); $i++)
                                    <tr class="intro-x">
                                        <td class="text-left">{{$smsDetails[$i]->datetime}}</td>
                                        <td class="text-left">{{$smsDetails[$i]->to_number}}</td>
                                        <td class="text-left">{{$smsDetails[$i]->sms}}</td>
                                    </tr>
                                    @endfor

                                </tbody>
                            </table>
                        </div>
                       
                    </div>   
                </div>
                <div id="example-tab-3" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-3-tab" style=""> 
                    <div class="overflow-x-auto scrollbar-hidden">
                        <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                            <table class="table table-report sm:mt-2">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">Date / Time</th>
                                        <th class="whitespace-nowrap">To Emails</th>
                                        <th class="whitespace-nowrap">Email Subject</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i=0; $i < count($escalationDetails); $i++)
                                    <tr class="intro-x">
                                        <td class="text-left">{{$escalationDetails[$i]->datetime}}</td>
                                        <td class="text-left">{{$escalationDetails[$i]->to_email}}</td>
                                        <td class="text-left">{{$escalationDetails[$i]->template_subject}}</td>
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
<input hidden id='user_type' value='{{$userType}}' />

@push('scripts')
<script>
    $(document).ready(function() {
        

        $("#txtCloseNotes").keyup(function(){
            $("#count").html("Characters left: <b>" + (255 - $(this).val().length + "/255</b>"));
        });

    });
    $(document).on('change', '#ddlProgress', function () {

        var progressValue = $(this).val();

        if(progressValue >= 90 && $('#user_type').val() == 2){
            $("#favorDiv").show();
            $("#closeNoteDiv").show();
        }else{
            $("#favorDiv").hide();
            $("#closeNoteDiv").hide();
        }

        console.log($('#user_type').val())

        });
   
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
    valProductCategory=document.getElementById('product_category').value;
    productB(valProductCategory);
   function productB(val) {
        let value = {
            product_category_id: val,
            end_date: 'not null'
        };
        $.ajax({
            type: 'GET',
            url: "{{ route('get_product_category') }}",
            data: value,
            success: function(result) {
                
                document.getElementById('product').innerHTML =
                        '<option value="0" selected="true">Select product</option>';
                    for (var i = 0; i < result.length; i++) {
                        var product = document.createElement('option');
                        product.value = result[i].id;
                        product.innerHTML = result[i].fullname;
                        if (result[i].id == "{{ $complaint[0]->product_id }}") product.defaultSelected =
                        true;
                        document.getElementById('product').appendChild(product);
                    }
                  
                   complaintType(document.getElementById('product').value);
            }
        });
    }
    
    function complaintType(val)
    {
        let value = {
            product_id: val,
            end_date: 'not null'
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
                        if (result[i].id == "{{ $complaint[0]->complaint_type_id }}") option.defaultSelected =
                        true;
                        document.getElementById('complaint_type').appendChild(option);
                    }
                    tatVal(document.getElementById('complaint_type'));
               
            }
        });
    }
        $(document).on('change', '#complaint_type', function () {
            
            tatVal(document.getElementById('complaint_type'));
            
        });
        
        function tatVal(complaintTypeId)
        {
            var tat_value = $('option:selected', complaintTypeId).attr('data-tat');
            
            $("#tatDisplay").html('<b> (TAT: ' + tat_value +' Days) </b>');
            $("#tatDisplay").show();
        }

  </script>
@endpush

@endsection
