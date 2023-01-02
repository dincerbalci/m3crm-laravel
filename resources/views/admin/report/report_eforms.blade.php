@extends('layouts.main')

@section('content')
<style>
    .grid-cols-12 {
    grid-template-columns: repeat(4, minmax(0, 1fr));
}
</style>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Reports
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        E-Form Reports
                    </h2>
                </div>
                <form id='complaint_form_search' method="GET" action="{{ route('report_eforms') }}" >
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                        <div >
                            <label for="regular-form-1" class="form-label">Status</label>
                                <select data-placeholder="Select your favorite actors"  name='status' class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="">Select Status </option>
                                    <option value="1" {{"1" == request()->status ? 'Selected' : ''}}>INITIATED</option>
                                    <option value="2" {{"2" == request()->status ? 'Selected' : ''}}>IN-PROGRESS</option>
                                    <option value="3" {{"3" == request()->status ? 'Selected' : ''}}>CLOSED</option>
                                </select>
                        </div>
                            <div class="">
                            <label for="regular-form-1" class="form-label">From Date</label>
                            <div id="basic-datepicker">
                                <div class="preview">
                                    <input type="text" name="from_date"  value="" class="datepicker form-control  block mx-auto" data-single-mode="true">
                                </div>
                               
                            </div>
                        </div>
                        <div class="">
                            <label for="regular-form-1" class="form-label">To Date</label>
                            <div id="basic-datepicker">
                                <div class="preview">
                                    <input type="text" name="to_date"  value="" class="datepicker form-control  block mx-auto" data-single-mode="true">
                                </div>
                               
                            </div>
                        </div>
                        
                        </div>
                        
                    </div>
                   
                    <button type="submit" class="btn btn-primary mt-5">Search</button>
                    <a href="{{route('report_eforms')}}"  class="btn btn-inverse mt-5">Reset</a>
                    {{-- <button type="submit" class="btn btn-success mt-5">Export</button> --}}
                </div>
            </form>

           
        </div>
     
     
    </div>
    </div>
 
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="intro-y flex items-center ">
            <h2 class="text-lg font-medium mr-auto">
                Report Data
            </h2>
        </div>
        <div class="overflow-x-auto scrollbar-hidden">
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">E-Form Num</th>
                            <th class="whitespace-nowrap">Category</th>
                            <th class="whitespace-nowrap">Product</th>
                            <th class="whitespace-nowrap">Type</th>
                            <th class="whitespace-nowrap">Status</th>
                            <th class="whitespace-nowrap">Assignee</th>
                            <th class="whitespace-nowrap">Closed Date</th>
                            <th class="whitespace-nowrap">Due Date</th>
                            <th class="whitespace-nowrap">Close Date</th>
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
                            <td class="text-left">{{$eForm[$i]->category}}</td>
                            <td class="text-left">{{$eForm[$i]->product}}</td>
                            <td class="text-left">{{$eForm[$i]->eform_type}}</td>
                            <td class="text-left"><span class='{{$label}}'>{{ $status}}</span></td>
                            <td class="text-left">{{$branchAssignee}}</td>
                            <td class="text-left">{{Date('Y-m-d',strtotime($eForm[$i]->current_datetime))}}</td>
                            <td class="text-left">{{Date('Y-m-d',strtotime($eForm[$i]->end_datetime))}}</td>
                            <td class="text-left">{{$eForm[$i]->closed_datetime != '0000-00-00 00:00:00' ? $leadTime : '-'}}</td>
                        </tr>
                        @endfor

                    </tbody>
                </table>
            </div>
            <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
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
