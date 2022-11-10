@extends('layouts.main')

@section('content')
 <!-- END: Side Menu -->
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="grid grid-cols-12 gap-6">
            {{--   2xl:col-span-9 --}}
            <div class="col-span-12 ">
                <div class="grid grid-cols-12 gap-6">
                    <!-- BEGIN: General Report -->
                    <div class="col-span-12 mt-8">
                        <div class="intro-y flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                General Report
                            </h2>
                            <a href="" class="ml-auto flex items-center text-primary"> <i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                        </div>
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="shopping-cart" class="report-box__icon text-primary"></i> 
                                            
                                            {{-- <div class="ml-auto">
                                                <div class="report-box__indicator bg-success tooltip cursor-pointer" title="33% Higher than last month"> 33% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                            </div> --}}
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">4.710</div>
                                        <div class="text-base text-slate-500 mt-1">TOTAL Complaints</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="credit-card" class="report-box__icon text-pending"></i> 
                                            {{-- <div class="ml-auto">
                                                <div class="report-box__indicator bg-danger tooltip cursor-pointer" title="2% Lower than last month"> 2% <i data-lucide="chevron-down" class="w-4 h-4 ml-0.5"></i> </div>
                                            </div> --}}
                                        </div>
                                            
                                        <div class="text-3xl font-medium leading-8 mt-6">3.721</div>
                                        <div class="text-base text-slate-500 mt-1">Closed Complaints</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="monitor" class="report-box__icon text-warning"></i> 
                                            {{-- <div class="ml-auto">
                                                <div class="report-box__indicator bg-success tooltip cursor-pointer" title="12% Higher than last month"> 12% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                            </div> --}}
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">2.149</div>
                                        <div class="text-base text-slate-500 mt-1">TOTAL E-Forms</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="user" class="report-box__icon text-success"></i> 
                                            {{-- <div class="ml-auto">
                                                <div class="report-box__indicator bg-success tooltip cursor-pointer" title="22% Higher than last month"> 22% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                            </div> --}}
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">152.040</div>
                                        <div class="text-base text-slate-500 mt-1">Closed E-Forms</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: General Report -->
                    <!-- BEGIN: Sales Report -->
                    <div class="col-span-12 lg:col-span-6 mt-8">
                        <div class="intro-y block sm:flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                Total Call by Agent
                            </h2>
                            {{-- <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i> 
                                <input type="text" class="datepicker form-control sm:w-56 box pl-10">
                            </div> --}}
                        </div>
                        <div class="intro-y box p-5 mt-5">
                        <div class="h-[400px]"> <canvas id="pie-chart-widget"></canvas> </div> 
                    </div> 
                       
                    </div>
                    <!-- END: Sales Report -->
                    <!-- BEGIN: Weekly Top Seller -->
                    <div class="col-span-12 lg:col-span-6 mt-8">
                        <div class="intro-y flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                Total Call (last 7 days)
                            </h2>
                            {{-- <a href="" class="ml-auto text-primary truncate">Show More</a>  --}}
                        </div>
                        <div class="intro-y box p-5 mt-5">
                            <div class="mt-3">
                                <div class="h-[400px]"> <canvas id="vertical-bar-chart-widget"></canvas>
                            </div>
                        </div>
                    </div>
                    </div>
                
                    <div class="col-span-12 mt-6">
                        <div class="intro-y block sm:flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                               Agent Activity Log (Last 10 Records)
                            </h2>
                        </div>
                        <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                            <table class="table table-report sm:mt-2">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">Call ID</th>
                                        <th class="whitespace-nowrap">Agent ID</th>
                                        <th class="whitespace-nowrap">Activity</th>
                                        <th class="whitespace-nowrap">Action On</th>
                                        <th class="whitespace-nowrap">Datetime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="intro-x">
                                        
                                        <td class="text-left">admin_50716_82340</td>
                                        <td class="text-left">Samsung Q90 QLED TV</td>
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
                            <select class="w-20 form-select box mt-3 sm:mt-0">
                                <option>10</option>
                                <option>25</option>
                                <option>35</option>
                                <option>50</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-span-12 2xl:col-span-6">
                        <div class="2xl:border-l -mb-10 pb-10">
                            <div class="2xl:pl-6 grid grid-cols-12 gap-x-6 2xl:gap-x-0 gap-y-6">
                                <!-- BEGIN: Important Notes -->
                                <div class="col-span-12 md:col-span-6 xl:col-span-12 mt-3 2xl:mt-8">
                                    <div class="intro-x flex items-center h-10">
                                        <h2 class="text-lg font-medium truncate mr-auto">
                                            Message
                                        </h2>
                                        <button data-carousel="important-notes" data-target="prev" class="tiny-slider-navigator btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2"> <i data-lucide="chevron-left" class="w-4 h-4"></i> </button>
                                        <button data-carousel="important-notes" data-target="next" class="tiny-slider-navigator btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2"> <i data-lucide="chevron-right" class="w-4 h-4"></i> </button>
                                    </div>
                                    <div class="mt-5 intro-x">
                                        <div class="box zoom-in">
                                            <div class="tiny-slider" id="important-notes">
                                                @for($i=0; $i < count($message); $i++)
                                                <div class="p-5">
                                                    <div class="text-base font-medium truncate">{{ucwords($message[$i]->subject)}}</div>
                                                    <div class="text-slate-400 mt-1">{{$message[$i]->created_at}}</div>
                                                    <div class="text-slate-500 text-justify mt-1">{{ucfirst($message[$i]->description)}}</div>
                                                    <div class="font-medium flex mt-5">
                                                    </div>
                                                </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              
                              
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 2xl:col-span-6">
                        <div class="2xl:border-l -mb-10 pb-10">
                            <div class="2xl:pl-6 grid grid-cols-12 gap-x-6 2xl:gap-x-0 gap-y-6">
                                <!-- BEGIN: Important Notes -->
                                <div class="col-span-12 md:col-span-6 xl:col-span-12 mt-3 2xl:mt-8">
                                    <div class="intro-x flex items-center h-10">
                                        <h2 class="text-lg font-medium truncate mr-auto">
                                            News & Announcement
                                        </h2>
                                        <button data-carousel="important-notes1" data-target="prev" class="tiny-slider-navigator btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2"> <i data-lucide="chevron-left" class="w-4 h-4"></i> </button>
                                        <button data-carousel="important-notes1" data-target="next" class="tiny-slider-navigator btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2"> <i data-lucide="chevron-right" class="w-4 h-4"></i> </button>
                                    </div>
                                    <div class="mt-5 intro-x">
                                        <div class="box zoom-in">
                                            <div class="tiny-slider" id="important-notes1">
                                                @for($i=0; $i < count($news); $i++)
                                                <div class="p-5">
                                                    <div class="text-base font-medium truncate">{{ucwords($news[$i]->subject)}}</div>
                                                    <div class="text-slate-400 mt-1">{{$news[$i]->created_at}}</div>
                                                    <div class="text-slate-500 text-justify mt-1">{{ucfirst($news[$i]->description)}}</div>
                                                    <div class="font-medium flex mt-5">
                                                    </div>
                                                </div>
                                                @endfor
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              
                              
                            </div>
                        </div>
                    </div>
                    <!-- END: Weekly Top Products -->
                </div>
            </div>
          
        </div>
    </div>
    <!-- END: Content -->
    

@endsection
