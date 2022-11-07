
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
                        Unit Listing
                    </h2>
                    <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                        <div class="w-56 relative text-slate-500">
                            <form method="GET" action="{{ route('unit.index') }}">
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
                                    <th class="whitespace-nowrap">Branch Name</th>
                                    <th class="whitespace-nowrap">Branch Code</th>
                                    <th class="whitespace-nowrap">Email</th>
                                    <th class="whitespace-nowrap">Is Active</th>
                                    <th class="whitespace-nowrap">Created Date</th>
                                    <th class="whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < count($unit); $i++) 
                                <tr class="intro-x">
                                <td class="text-left">{{ucwords($unit[$i]->unit_name)}}</td>
                                    <td class="text-left">{{ucwords($unit[$i]->branch_code)}}</td>
                                    <td class="text-left">{{ucwords($unit[$i]->email)}}</td>
                                    <td class="text-left">{{ucwords($unit[$i]->is_active == '1' ? 'yes' : 'no' )}}</td>
                                    <td class="text-left">{{Date('Y-m-d',strtotime($unit[$i]->created_on))}}</td>
                                    <td class="text-left flex"> 
                                        <a class="flex items-center mr-3" href="{{route('unit.edit',$unit[$i]->id)}}"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                        <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a></td>
                                </tr>
                                @endfor

                            </tbody>
                        </table>
                    </div>
                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                        {{ $unit->links('paginate.paginate_ui') }}
                    </div>
                </div>

           
        </div>
     
     
    </div>
</div>

@endsection
