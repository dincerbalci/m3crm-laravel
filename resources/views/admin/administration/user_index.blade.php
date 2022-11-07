
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
            Administration
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        User Search
                    </h2>
                </div>
                <form id='user_search' method="GET" action="{{ route('user.index') }}">
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                        <div >
                            <label for="regular-form-1" class="form-label">Group Name</label>
                                <select data-placeholder="Select your favorite actors" name="group_id" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="0" selected="true">Select Group Name </option>
                                    @for ($i = 0; $i < count($group); $i++) 
                                    <option value="{{$group[$i]->id}}" {{request()->group_id == $group[$i]->id ? 'Selected' : ''}}>{{ucwords($group[$i]->group_name)}}</option>
                                    @endfor
                                </select>
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">E-Mail</label>
                            <input type="email" name="email" class="form-control col-span-4" value="{{request()->email}}" placeholder="abc@gmail.com" aria-label="default input inline 2">
                        </div>
                        <div >
                            <label for="regular-form-1" class="form-label">Status</label>
                                <select data-placeholder="Select your favorite actors" name="status" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="99" <?php echo (request()->status == '99' ? "selected='selected'" : ''); ?>>All</option>
                                    <option value="active" <?php echo (request()->status == 'active' ? "selected='selected'" : ''); ?>>Active</option>
                                    <option value="inactive" <?php echo (request()->status == 'inactive' ? "selected='selected'" : ''); ?>>Deactive</option>
                                </select>
                        </div>
                       
                        
                        </div>
                        
                    </div>
                   
                    <button type="submit" class="btn btn-primary mt-5">Search</button>
                    <a href="{{route('user.index')}}"  class="btn btn-inverse mt-5">Reset</a>
                    <button type="button" class="btn btn-success mt-5">Export</button>
                </div>
                </form>

           
        </div>
     
     
    </div>
</div>
 
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <form method="GET" action="{{ route('user.index') }}">
                    <input type="text" name="search" class="form-control w-56 box pr-10" value="{{request()->search}}" placeholder="Search...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i> 
                    </form>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto scrollbar-hidden">
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">Id</th>
                            <th class="whitespace-nowrap">User Id</th>
                            <th class="whitespace-nowrap">Group</th>
                            <th class="whitespace-nowrap">Branch</th>
                            <th class="whitespace-nowrap">Role</th>
                            <th class="whitespace-nowrap">Full name</th>
                            <th class="whitespace-nowrap">Status</th>
                            <th class="whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                        $a=$user->currentPage() == '1' ? '0' : $user->perPage()*($user->currentPage()-1);
                       @endphp
                       @for ($i = 0; $i < count($user); $i++) @php  $a++; @endphp
                        <tr class="intro-x">
                            
                            <td class="text-left">{{$a}}</td>
                            <td class="text-left">{{ucwords($user[$i]->user_name)}}</td>
                            <td class="text-left">{{ucwords($user[$i]->user_type_name != "" ? $user[$i]->user_type_name : "Admin") }}</td>
                            <td class="text-left">{{ucwords($user[$i]->branch_name != "" ? $user[$i]->branch_name : "Admin" )}}</td>
                            <td class="text-left">{{ucwords($user[$i]->role_name != "" ? $user[$i]->role_name : "Admin" )}}</td>
                            <td class="text-left">{{ucwords($user[$i]->first_name)}} {{ucwords($user[$i]->last_name)}}</td>
                            <td class="text-left">{{ucwords($user[$i]->isactive == "1" ? "Active" : "In-Active" ) }}</td>
                            <td class="text-left flex"> 
                                <a class="flex items-center mr-3" href="{{route('user.edit',$user[$i]->id)}}"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                <a class="flex items-center text-danger" href="{{route('user_status',$user[$i]->id)}}" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal">{{ucwords($user[$i]->isactive == "1" ? "Active" : "In-Active" ) }}</td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                {{ $user->links('paginate.paginate_ui') }}
            </div>
        </div>
    </div>
    <!-- END: HTML Table Data -->


@endsection
