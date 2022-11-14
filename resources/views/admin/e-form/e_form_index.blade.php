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
            E-Form Management
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        E-Form Search
                    </h2>
                </div>
                <form id="e_form_search"  method="Get" action="{{ route('e_form_index') }}" enctype="multipart/form-data">
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div>
                            <label for="regular-form-1" class="form-label">E-Form Num</label>
                            <input type="text" class="form-control col-span-4" value="{{request()->form_number}}" name="form_number" placeholder="E-Form Num" aria-label="default input inline 1">
                            </div>
                            <div>
                            <label for="regular-form-1" class="form-label">CNIC </label>
                            <input type="text" class="form-control col-span-4" value="{{request()->cnic}}" id='cnic' name="cnic" placeholder="CNIC" aria-label="default input inline 2">
                        </div>
                        <div >
                            <label for="regular-form-1" class="form-label">Priority</label>
                                <select data-placeholder="Select your favorite actors" name="priority" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="0" selected="true">Select priority </option>
                                    @for($i=0; $i < count($priority); $i++ )
                                    <option value="{{$priority[$i]->id}}" {{$priority[$i]->id == request()->priority ? 'Selected' : ''}}>{{ucwords($priority[$i]->priority)}}</option>
                                    @endfor
                                </select>
                        </div>
                        <div >
                            <label for="regular-form-1" class="form-label">E-Form Status</label>
                                <select data-placeholder="Select your favorite actors" name="status" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="0" selected="true">All E-Form  </option>
                                    @for($i=0; $i < count($status); $i++ )
                                    <option value="{{$status[$i]->id}}" {{$status[$i]->id == request()->status ? 'Selected' : ''}}>{{ucwords($status[$i]->fullname)}}</option>
                                    @endfor
                                </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Product</label>
                                <select data-placeholder="Select your favorite actors" name="product" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="0" selected="true">All Product</option>
                                    @for($i=0; $i < count($product); $i++ )
                                    <option value="{{$product[$i]->id}}" {{$product[$i]->id == request()->product ? 'Selected' : ''}}>{{ucwords($product[$i]->fullname)}}</option>
                                    @endfor
                                </select>
                        </div>
                            <div class="mt-3">
                            <label for="regular-form-1" class="form-label">From Date</label>
                            <div id="basic-datepicker">
                                <div class="preview">
                                    <input type="text" name="from_date" class="datepicker form-control  block mx-auto" data-single-mode="true">
                                </div>
                               
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">To Date</label>
                            <div id="basic-datepicker">
                                <div class="preview">
                                    <input type="text" name="to_date" class="datepicker form-control  block mx-auto" data-single-mode="true">
                                </div>
                               
                            </div>
                        </div>
                        
                        </div>
                        
                    </div>
                   
                    <button type="submit" class="btn btn-primary mt-5">Search</button>
                    <a href="{{route('e_form_index')}}"  class="btn btn-inverse mt-5">Reset</a>
                    <button type="submit" class="btn btn-success mt-5">Export</button>
                </div>
                </form>

           
        </div>
     
     
    </div>
</div>
 
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="intro-y flex items-center ">
            <h2 class="text-lg font-medium mr-auto">
                E-Form Data
            </h2>
        </div>
        <div class="overflow-x-auto scrollbar-hidden">
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">E-Form Num</th>
                            <th class="whitespace-nowrap">Released By</th>
                            <th class="whitespace-nowrap">Customer Branch Name & Code</th>
                            <th class="whitespace-nowrap">Product</th>
                            <th class="whitespace-nowrap">Type</th>
                            <th class="whitespace-nowrap">Progress</th>
                            <th class="whitespace-nowrap">Priority</th>
                            <th class="whitespace-nowrap">Status</th>
                            <th class="whitespace-nowrap">Assignee</th>
                            <th class="whitespace-nowrap">Created Date</th>
                            <th class="whitespace-nowrap">Due Date</th>
                            <th class="whitespace-nowrap">Closed Date</th>
                            <th class="whitespace-nowrap">Lead Time</th>
                            <th class="whitespace-nowrap">File Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i < count($eForm); $i++ )
                        @php 
                           $status = "";
                            $checkOver = App\Http\Controllers\ComplaintManagementController::CheckOverDue($eForm[$i]->end_datetime);
                            $leadTime = LeadTime($eForm[$i]->current_datetime, $eForm[$i]->closed_datetime) . " Day(s)";
                            $branchAssignee = $eForm[$i]->assign_branch == '' ? 'Not Assign' : $eForm[$i]->assign_branch;
                            if($eForm[$i]->status_id == '1'){

                                if($userType == 2 || $loginId == 1){
                                    $eForm[$i]->eform_status = "Need Forwarding";
                                }

                                $status = strtoupper($eForm[$i]->eform_status);
                                if($checkOver == 1){
                                    $label = "bg-danger/20 text-danger rounded px-2 mr-5";
                                }else
                                    $label = "bg-gray-100 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300";

                            }
                            else if($eForm[$i]->status_id == '2'){
                                //only in progress status check for overdue
                                if($checkOver == 1){
                                    $status = "OVERDUE";
                                    $label = "bg-danger/20 text-danger rounded px-2 mr-5";
                                }else{
                                    if(($userType != 1 || $userType != 3) && $eForm[$i]->progress != 0)
                                        $status = "IN PROGRESS";
                                    else
                                        $status = "FORWARD";

                                    $label = "bg-gray-100 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300";

                                }

                            }
                            else if($eForm[$i]->status_id == '4'){

                                $status = strtoupper($eForm[$i]->eform_status);
                                $label = "bg-success/20 text-success rounded px-2 mr-5";

                            }
                            else if($eForm[$i]->status_id == '3'){

                                $status = strtoupper($eForm[$i]->eform_status);
                                $label = "bg-warning/20 text-warning rounded px-2 mr-5";
                            }
                            else if($eForm[$i]->status_id == '5'){

                                $status = strtoupper($eForm[$i]->eform_status);
                                $label = "bg-indigo-100 text-indigo-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-indigo-200 dark:text-indigo-900";
                            }
                        @endphp
                        <tr class="intro-x">
                            <td class="text-left "><a class="colorchange" href="{{route('e_form_show',$eForm[$i]->id)}}">{{$eForm[$i]->eform_num}}</a></td>
                            <td class="text-left">{{$eForm[$i]->released_by}}</td>
                            <td class="text-left">{{$eForm[$i]->branch}}</td>
                            <td class="text-left">{{$eForm[$i]->product}}</td>
                            <td class="text-left">{{$eForm[$i]->eform_type}}</td>
                            <td class="text-left">
                                <div class="relative pt-1">
                                    <div class="flex mb-2 items-center justify-between">
                                      <div class="text-right">
                                        <span class="text-xs font-semibold inline-block text-pink-600">
                                            {{$eForm[$i]->progress}}%
                                        </span>
                                      </div>
                                    </div>
                                    <div class="progress h-4">
                                      <div style="width:{{$eForm[$i]->progress}}%" class="progress-bar"></div>
                                    </div>
                                  </div>
                                {{-- <div class="progress h-4">
                                <div class="progress-bar" style="width: {{$eForm[$i]->progress}}%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">{{$eForm[$i]->progress}}%</div> --}}
                            </div>
                            </td>
                            <td class="text-left">{{$eForm[$i]->priority}}</td>
                            <td class="text-left"><span class='{{$label}}'>{{ $status}}</span></td>
                            <td class="text-left">{{$branchAssignee}}</td>
                            <td class="text-left">{{Date('Y-m-d',strtotime($eForm[$i]->current_datetime))}}</td>
                            <td class="text-left">{{Date('Y-m-d',strtotime($eForm[$i]->end_datetime))}}</td>
                            <td class="text-left">{{$eForm[$i]->closed_datetime != '0000-00-00 00:00:00' ? date('Y-m-d', strtotime($eForm[$i]->closed_datetime)) : '-' }}</td>
                            <td class="text-left">{{$eForm[$i]->closed_datetime != '0000-00-00 00:00:00' ? $leadTime : '-'}}</td>
                            <td class="text-left"><a href="{{ asset($eForm[$i]->file_path)}}">Download</a></td>
                        </tr>
                        @endfor

                    </tbody>
                </table>
            </div>
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                {{ $eForm->links('paginate.paginate_ui') }}
            </div>
        </div>
    </div>
    <!-- END: HTML Table Data -->
    @push('scripts')
    <script>
        // var date = $('#from_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
        $('input[name="to_date"]').val('{{request()->to_date}}')
        $('input[name="from_date"]').val('{{request()->from_date}}')
    </script>
    @endpush


@endsection
