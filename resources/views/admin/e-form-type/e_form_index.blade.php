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
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div>
                            <label for="regular-form-1" class="form-label">E-Form Num</label>
                            <input type="text" class="form-control col-span-4" placeholder="E-Form Num" aria-label="default input inline 1">
                            </div>
                            <div>
                            <label for="regular-form-1" class="form-label">CNIC </label>
                            <input type="text" class="form-control col-span-4" id='cnic' placeholder="CNIC" aria-label="default input inline 2">
                        </div>
                        <div >
                            <label for="regular-form-1" class="form-label">Priority</label>
                                <select data-placeholder="Select your favorite actors" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="0" selected="true">Select priority </option>
                                    <option value="3" >Robert Downey, Jr</option>
                                    <option value="1">Leonardo DiCaprio</option>
                                    <option value="2">Johnny Deep</option>
                                    <option value="4">Samuel L. Jackson</option>
                                    <option value="5">Morgan Freeman</option>
                                </select>
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Call Back Phone</label>
                            <input type="text" class="form-control col-span-4 number" placeholder="92xxxxxxxxxxx" aria-label="default input inline 2">
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">E-Form Status</label>
                                <select data-placeholder="Select your favorite actors" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="0" selected="true">All E-Form  </option>
                                    <option value="3" >Robert Downey, Jr</option>
                                    <option value="1">Leonardo DiCaprio</option>
                                    <option value="2">Johnny Deep</option>
                                    <option value="4">Samuel L. Jackson</option>
                                    <option value="5">Morgan Freeman</option>
                                </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Product</label>
                                <select data-placeholder="Select your favorite actors" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="0" selected="true">All Product</option>
                                    <option value="3" >Robert Downey, Jr</option>
                                    <option value="1">Leonardo DiCaprio</option>
                                    <option value="2">Johnny Deep</option>
                                    <option value="4">Samuel L. Jackson</option>
                                    <option value="5">Morgan Freeman</option>
                                </select>
                        </div>
                            <div class="mt-3">
                            <label for="regular-form-1" class="form-label">From Date</label>
                            <div id="basic-datepicker">
                                <div class="preview">
                                    <input type="text" class="datepicker form-control  block mx-auto" data-single-mode="true">
                                </div>
                               
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">To Date</label>
                            <div id="basic-datepicker">
                                <div class="preview">
                                    <input type="text" class="datepicker form-control  block mx-auto" data-single-mode="true">
                                </div>
                               
                            </div>
                        </div>
                        
                        </div>
                        
                    </div>
                   
                    <button type="submit" class="btn btn-primary mt-5">Search</button>
                    <button type="submit" class="btn btn-inverse mt-5">Reset</button>
                    <button type="submit" class="btn btn-success mt-5">Export</button>
                </div>

           
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
                            <th class="whitespace-nowrap">Branch Name & Code</th>
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
                        <tr class="intro-x">
                            
                            <td class="text-left">admin_50716_82340</td>
                            <td class="text-left">Samsung Q90 QLED TV</td>
                            <td class="text-left">End CLI</td>
                            <td class="text-left">End CLI</td>
                            <td class="text-left">End CLI</td>
                            <td class="text-left">End CLI</td>
                            <td class="text-left">End CLI</td>
                            <td class="text-left">End CLI</td>
                            <td class="text-left">End CLI</td>
                            <td class="text-left">End CLI</td>
                            <td class="text-left">End CLI</td>
                            <td class="text-left">End CLI</td>
                            <td class="text-left">42301-2082228-5</td>
                            <td class="text-left">2020-10-05 13:00:38</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
                <nav class="w-full sm:w-auto sm:mr-auto">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevrons-left"></i> </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevron-left"></i> </a>
                        </li>
                        <li class="page-item"> <a class="page-link" href="#">...</a> </li>
                        <li class="page-item"> <a class="page-link" href="#">1</a> </li>
                        <li class="page-item active"> <a class="page-link" href="#">2</a> </li>
                        <li class="page-item"> <a class="page-link" href="#">3</a> </li>
                        <li class="page-item"> <a class="page-link" href="#">...</a> </li>
                        <li class="page-item">
                            <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevron-right"></i> </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevrons-right"></i> </a>
                        </li>
                    </ul>
                </nav>
                {{-- <select class="w-20 form-select box mt-3 sm:mt-0">
                    <option>10</option>
                    <option>25</option>
                    <option>35</option>
                    <option>50</option>
                </select> --}}
            </div>
        </div>
    </div>
    <!-- END: HTML Table Data -->
    


@endsection
