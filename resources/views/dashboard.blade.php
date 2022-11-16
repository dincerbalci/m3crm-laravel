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
                                        <div class="text-3xl font-medium leading-8 mt-6">4710</div>
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
                                            
                                        <div class="text-3xl font-medium leading-8 mt-6">3721</div>
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
                                        <div class="text-3xl font-medium leading-8 mt-6">2149</div>
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
                                        <div class="text-3xl font-medium leading-8 mt-6">152040</div>
                                        <div class="text-base text-slate-500 mt-1">Closed E-Forms</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-6 mt-8">
                        <div class="intro-y block sm:flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                Complaints Report
                            </h2>
                        </div>
                        <div class="intro-y box p-5 mt-12 sm:mt-5">
                                <canvas class="p-10" id="chartPie"></canvas>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-6 mt-8">
                        <div class="intro-y block sm:flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                E-Forms Report
                            </h2>
                        </div>
                        <div class="intro-y box p-5 mt-12 sm:mt-5">
                            <canvas class="p-10" id="chartDoughnut"></canvas>
                        </div>
                    </div>
                    <!-- END: General Report -->
                    <!-- BEGIN: Sales Report -->
                    @if(count($message) > 0)
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
                    @endif
                    @if(count($news) > 0)
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
                    @endif
                    @if(count($agentActivityLogs) > 0)
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
                                    @for($i=0; $i < count($agentActivityLogs); $i++)
                                    <tr class="intro-x">
                                        <td class="text-left">{{$agentActivityLogs[$i]->call_id}}</td>
                                        <td class="text-left">{{$agentActivityLogs[$i]->agent_id}}</td>
                                        <td class="text-left">{{$agentActivityLogs[$i]->description}}</td>
                                        <td class="text-left">{{$agentActivityLogs[$i]->action_on}}</td>
                                        <td class="text-left">{{$agentActivityLogs[$i]->created_datetime}}</td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    @endif
                    <!-- END: Weekly Top Products -->
                </div>
            </div>
          
        </div>
    </div>
    <!-- END: Content -->
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const dataPie = {
          labels: ["Total Complaint", "Closed Complaint", "In Process Complaint"],
          datasets: [
            {
              label: "",
              data: [4710, 3721, 989],
              backgroundColor: [
                "rgb(23 90 114)",
                "rgb(200 112 13)",
                "rgb(225 148 18)",
              ],
             
              hoverOffset: 4,
            },
          ],
        };
      
        const configPie = {
          type: "pie",
          data: dataPie,
          options: {},
        };
      
        var chartBar = new Chart(document.getElementById("chartPie"), configPie);

        /// e-form
        const dataDoughnut = {
    labels: ["Total E-Forms", "Closed E-Forms", "In Process E-Forms"],
    datasets: [
      {
        label: "",
        data: [300, 50, 100],
        backgroundColor: [
            "rgb(23 90 114)",
            "rgb(200 112 13)",
            "rgb(225 148 18)",
        ],
        hoverOffset: 4,
      },
    ],
  };

  const configDoughnut = {
    type: "doughnut",
    data: dataDoughnut,
    options: {},
  };

  var chartBar = new Chart(
    document.getElementById("chartDoughnut"),
    configDoughnut
  );
      </script>
@endpush

@endsection
