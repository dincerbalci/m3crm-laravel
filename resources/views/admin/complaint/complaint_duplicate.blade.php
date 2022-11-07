<div class="overflow-x-auto scrollbar-hidden">
    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
        <table class="table table-report sm:mt-2">
            <thead>
                <tr>
                    <th class="whitespace-nowrap">Complaint Number</th>
                    <th class="whitespace-nowrap">Complaint Title</th>
                    <th class="whitespace-nowrap">CNIC</th>
                    <th class="whitespace-nowrap">Progress Bar</th>
                    <th class="whitespace-nowrap">Priority</th>
                    <th class="whitespace-nowrap">Status</th>
                    <th class="whitespace-nowrap">Created at</th>
                    <th class="whitespace-nowrap">End Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($getDuplicate as $row)
                @php
                $checkOver=App\Http\Controllers\ComplaintManagementController::CheckOverDue($row->end_date);

                    if($row->status_id == '1'){

                        $status = strtoupper($row->complaint_status);
                        if($checkOver == 1){
                            $label = "bg-danger/20 text-danger rounded px-2 mr-5";
                        }else
                            $label = "bg-success/20 text-success rounded px-2 mr-5";

                    }
                    else if($row->status_id == '2'){
                        //only in progress status check for overdue
                        if($checkOver == 1){
                            $status = "OVERDUE";
                            $label = "bg-danger/20 text-danger rounded px-2 mr-5";
                        }else{
                            if(($userType != 1 || $userType != 3) && $row->progress != 0)
                                $status = "IN PROGRESS";
                            else
                                $status = "FORWARD";

                            $label = "bg-success/20 text-success rounded px-2 mr-5";
                        }

                    }
                @endphp
                <tr class="intro-x">
                    <td class="text-left">{{$row->complaint_num}}</td>
                    <td class="text-left">{{$row->compl_title}}</td>
                    <td class="text-left">{{$row->cnic}}</td>
                    <td class="text-left"><div class="progress h-4">
                        <div class="progress-bar" style="width: {{$row->progress}}%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">{{$row->progress}}%</div>
                    </div></td>
                    <td class="text-left">{{$row->priority}}</td>
                    <td class="text-left"><span class='{{$label}}'>{{$status}}</span></td>
                    <td class="text-left">{{Date("Y-m-d",strtotime($row->create_date))}}</td>
                    <td class="text-left">{{Date("Y-m-d",strtotime($row->end_date))}}</td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>