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
                        Agent Activity Logs Reports
                    </h2>
                </div>
                <form id='complaint_form_search' method="GET" action="{{ route('report_agent_activity_logs') }}" >
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">

                        <div >
                            <label for="regular-form-1" class="form-label">Agent</label>
                                <select data-placeholder="Select your favorite actors"  name='agent' class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="">Select Agent </option>
                                    @for($i=0; $i < count($agents); $i++)
                                    <option value="{{$agents[$i]->id}}" {{$agents[$i]->id == request()->agent ? 'Selected' : ''}}>{{ucwords($agents[$i]->user_name)}}</option>
                                    @endfor
                                </select>
                        </div>
                        <div class="">
                            <label for="regular-form-1" class="form-label">Activity Name</label>
                                <select data-placeholder="Select your favorite actors" name="activity_name"  class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="All Activity" >All Activity</option>
                                    @for($i=0; $i < count($activities); $i++)
                                    <option value="{{$activities[$i]->fullname}}" {{$activities[$i]->fullname == request()->activity_name ? 'Selected' : ''}}>{{ucwords($activities[$i]->fullname)}}</option>
                                    @endfor
                                </select>
                        </div>
                            <div>
                            <label for="regular-form-1" class="form-label">Search </label>
                            <input type="text" class="form-control col-span-4" id='cnic_mobile_account' value="{{request()->cnic_mobile_account}}" name="cnic_mobile_account" placeholder="CNIC/Mobile/Account" aria-label="default input inline 2">
                        </div>
                            <div class="">
                            <label for="regular-form-1" class="form-label">From Date</label>
                            <div id="basic-datepicker">
                                <div class="preview">
                                    <input type="text" name="from_date"  value="" class="datepicker form-control  block mx-auto" data-single-mode="true">
                                </div>
                               
                            </div>
                        </div>
                        <div class="mt-3">
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
                    <a href="{{route('report_agent_activity_logs')}}"  class="btn btn-inverse mt-5">Reset</a>
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
                            <th class="whitespace-nowrap">Call ID</th>
                            <th class="whitespace-nowrap">Agent ID</th>
                            <th class="whitespace-nowrap">Activity Name</th>
                            <th class="whitespace-nowrap">Action On</th>
                            <th class="whitespace-nowrap">Date Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i < count($data); $i++)
                        
                        <tr class="intro-x">
                            <td class="text-left">{{ $data[$i]->call_id}}</td>
                            <td class="text-left">{{ $data[$i]->agent_id}}</td>
                            <td class="text-left">{{ $data[$i]->description}}</td>
                            <td class="text-left">{{ $data[$i]->action_on}}</td>
                            <td class="text-left">{{ date("Y-m-d",strtotime($data[$i]->created_datetime))}}</td>
                            <td class="text-left">
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
                    {{ $data->links('paginate.paginate_ui') }}
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
