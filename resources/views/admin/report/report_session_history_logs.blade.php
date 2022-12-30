@extends('layouts.main')

@section('content')
    <h2 class="intro-y text-lg font-medium mt-10">
        Session History Logs
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
          
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <form method="GET" action="{{ route('report_session_history_logs') }}">
                    <input type="text" name="search" class="form-control w-56 box pr-10" value="{{request()->search}}" placeholder="Search...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i> 
                    </form>
                </div>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">Id</th>
                        <th class="whitespace-nowrap">User Name</th>
                        <th class="whitespace-nowrap">User Ip</th>
                        <th class="whitespace-nowrap">Login Time</th>
                        <th class="whitespace-nowrap">logout Time</th>
                        <th class="whitespace-nowrap">User Agent</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < count($data); $i++)
                    <tr class="intro-x">
                        <td class="text-left">{{$data[$i]->id}}</td>
                        <td class="text-left">{{$data[$i]->user_name}}</td>
                        <td class="text-left">{{$data[$i]->user_ip}}</td>
                        <td class="text-left">{{$data[$i]->login_datetime}}</td>
                        <td class="text-left">{{$data[$i]->logout_datetime}}</td>
                        <td class="text-left">{{$data[$i]->user_agent}}</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            {{ $data->links('paginate.paginate_ui') }}
        </div>
        <!-- END: Pagination -->
    </div>
   
@endsection
