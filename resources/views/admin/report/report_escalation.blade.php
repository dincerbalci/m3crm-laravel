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
                        Escalations Exceptional Detailed Report
                    </h2>
                </div>
                <form id='complaint_form_search' method="GET" action="{{ route('report_escalation') }}" >
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div>
                                <label for="regular-form-1" class="form-label">Complaint Number</label>
                                <input type="text" class="form-control col-span-4" id='complaint_number' value="{{request()->complaint_number}}" name="complaint_number" placeholder="CTyymmdd000" aria-label="default input inline 2">
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
                    <a href="{{route('report_escalation')}}"  class="btn btn-inverse mt-5">Reset</a>
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
                            <th class="whitespace-nowrap" style="width: 6%;">Complaint No.</th>
                            <th class="whitespace-nowrap" style="width: 12%;">Br.Name & Code</th>
                            <th class="whitespace-nowrap" style="width: 13%;">Complaint Receiving / Lodgment Date</th>
                            <th class="whitespace-nowrap" style="width: 10%;">Complainant Name</th>
                            <th class="whitespace-nowrap" style="width: 9%;">CNIC No.</th>
                            <th class="whitespace-nowrap" style="width: 1%;">Source</th>
                            <th class="whitespace-nowrap" style="width: 12%;">Lodge By</th>
                            <th class="whitespace-nowrap" style="width: 15%;">Description</th>
                            <th class="whitespace-nowrap" style="width: 12%;">Product</th>
                            <th class="whitespace-nowrap" style="width: 12%;">Type</th>
                            <th class="whitespace-nowrap" style="width: 7%;">Status</th>
                            <th class="whitespace-nowrap" style="width: 10%;">Aging</th>
                            <th class="whitespace-nowrap" style="width: 10%;">Remaining TAT Days</th>
                            <th class="whitespace-nowrap" style="width: 15%;">Current Escalation Level</th>
                            <th class="whitespace-nowrap" style="width: 15%;">Escalated Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i < count($complaint); $i++)
                        @php
                        $checkOver=App\Http\Controllers\ComplaintManagementController::CheckOverDue($complaint[$i]->end_date);
                        $escalations = explode("|",$complaint[$i]->current_escalation_level);
                        $currentLevel = $escalations[0];
                        $currentLevelDate = $escalations[1];
                        $currentLevel = $currentLevel != "Complai" ? $currentLevel : "";
                        $currentLevelDate = $currentLevel != "Complai" ? $currentLevelDate : "";
                        

                            if($complaint[$i]->status_id == '1'){
        
                                $status = strtoupper($complaint[$i]->complaint_status);
                                if($checkOver == 1){
                                    $label = "bg-danger/20 text-danger rounded px-2 mr-5";
                                }else
                                    $label = "bg-gray-100 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300";
        
                            }
                            else if($complaint[$i]->status_id == '2'){
                                //only in progress status check for overdue
                                if($checkOver == 1){
                                    $status = "OVERDUE";
                                    $label = "bg-danger/20 text-danger rounded px-2 mr-5";
                                }else{
                                    if(($userType != 1 || $userType != 3) && $complaint[$i]->progress != 0)
                                        $status = "IN PROGRESS";
                                    else
                                        $status = "FORWARD";
        
                                    $label = "bg-gray-100 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300";
                                }
                            }
                        else if($complaint[$i]->status_id == '4'){

                            $status = strtoupper($complaint[$i]->complaint_status);
                            $label = "bg-success/20 text-success rounded px-2 mr-5";

                            }
                        else if($complaint[$i]->status_id == '3'){

                        $status = strtoupper($complaint[$i]->complaint_status);
                        $label = "bg-warning/20 text-warning rounded px-2 mr-5";

                        }else if($complaint[$i]->status_id == '5'){

                        $status = strtoupper($complaint[$i]->complaint_status);
                        $label = "bg-indigo-100 text-indigo-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-indigo-200 dark:text-indigo-900";

                        }
                        
                        $complaintAging = GetComplaintAging(date('Y-m-d', strtotime($complaint[$i]->create_date . ' +1 day')), $complaint[$i]->close_date) ;
                        if($complaint[$i]->status_id == '3'){
                            $remainingTatDays = "0 Day(s)";
                        }else{ 
                            $difference = ($complaint[$i]->tat - $complaintAging);
                            $remainingTatDays = $difference > 0 ? $difference : 0;
                            $remainingTatDays .= " Day(s)";
                        }
                        @endphp
                        <tr class="intro-x">
                            <td class="text-left" style="width: 6%;"><a class="colorchange" href="{{route('complaint_show',$complaint[$i]->complaint_id)}}">{{$complaint[$i]->complaint_num}}</a></td>
                            <td class="text-left" style="width: 12%;">{{ ucwords($complaint[$i]->customer_branch)}}</td>
                            <td class="text-left" style="width: 13%;">{{ DATE("Y-m-d",strtotime($complaint[$i]->create_date))}}</td>
                            <td class="text-left" style="width: 10%;">{{ ucwords($complaint[$i]->customer_name)}}</td>
                            <td class="text-left" style="width: 15%;">{{ $complaint[$i]->cnic}} </td>
                            <td class="text-left" style="width: 15%;">{{ $complaint[$i]->source_name}} </td>
                            <td class="text-left" style="width: 15%;">{{ $complaint[$i]->lodge_by}} </td>
                            <td class="text-left" style="width: 15%;">{{ $complaint[$i]->description}} </td>
                            <td class="text-left" style="width: 15%;">{{ $complaint[$i]->product_name}} </td>
                            <td class="text-left" style="width: 15%;">{{ $complaint[$i]->complaint_type}} </td>
                            <td class="text-left" style="width: 9%;"><span class='{{$label}}'>{{ $status}}</span></td>
                            <td class="text-left" style="width: 10%;">{{$complaintAging}}</td>
                            <td class="text-left" style="width: 10%;">{{$remainingTatDays}}</td>
                            <td class="text-left" style="width: 15%;">{{$currentLevel}}</td>
                            <td class="text-left" style="width: 15%;">{{date("Y-m-d",strtotime($currentLevelDate))}}</td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
                    {{ $complaint->links('paginate.paginate_ui') }}
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
