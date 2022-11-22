@extends('layouts.main')

@section('content')
    <h2 class="intro-y text-lg font-medium mt-10">
        Product Complaint
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
          
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <form method="GET" action="{{ route('complaint_product_index') }}">
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
                        <th class="whitespace-nowrap">Product Code</th>
                        <th class="whitespace-nowrap">Product Category</th>
                        <th class="whitespace-nowrap">Product Name</th>
                        <th class="whitespace-nowrap">Is Active</th>
                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                    $a=$complaintProduct->currentPage() == '1' ? '0' : $complaintProduct->perPage()*($complaintProduct->currentPage()-1);
                   @endphp
                      @for ($i = 0; $i < count($complaintProduct); $i++) @php  $a++; @endphp
                    <tr class="intro-x">
                        <td class="text-left">{{$a}}</td>
                        <td class="text-left">{{$complaintProduct[$i]->product_code}}</td>
                        <td class="text-left">{{ucwords($complaintProduct[$i]->complaintCategory->fullname)}}</td>
                        <td class="text-left">{{ucwords($complaintProduct[$i]->fullname)}}</td>
                        <td class="text-left">{{ucwords($complaintProduct[$i]->isactive == '1' ? 'yes' : 'no' )}}</td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center mr-3" href="{{route('complaint_product_edit',$complaintProduct[$i]->id)}}"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                            </div>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            {{ $complaintProduct->links('paginate.paginate_ui') }}

        </div>
        <!-- END: Pagination -->
    </div>
    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i> 
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">
                            Do you really want to delete these records? 
                            <br>
                            This process cannot be undone.
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                        <button type="button" class="btn btn-danger w-24">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->
    


@endsection
