<div class="flex overflow-hidden">
    <!-- BEGIN: Side Menu -->
    <nav class="side-nav">
        <ul>
            <li>
                <li>
                    <a href="{{route('dashboard')}}" class="side-menu {{ Route::currentRouteName() == 'dashboard'   ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                        <div class="side-menu__title"> Dashboard </div>
                    </a>
                </li>
            </li>
            {{-- onclick="sideBarView('19')"   --}}
            @php  $sidebarMenu=Session::get('sidebar_menu');
           
            @endphp
            @foreach($sidebarMenu AS $key => $data)
            <li>
                <a href="javascript:;" class="side-menu  "  onclick="sideBarView('{{$data[0]->parent_id}}')">
                    <div class="side-menu__icon"> <?php echo html_entity_decode($data[0]->modules_icon) ?> </div>
                    <div class="side-menu__title">
                        {{$key}}
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul >
                    @foreach($data AS $key => $val)
                    @if(is_numeric($key))
                    <li>
                        <a href="{{route($val->page_name)}}" class="side-menu {{ Route::currentRouteName() == $val->page_name  ? 'side-menu--active' : '' }}">
                            <div class="side-menu__title">{{$val->page_title}}</div>
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="javascript:;" class="side-menu  "  >
                            <div class="side-menu__title">
                                {{$key}}
                                <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="">
                            @for ($i=0; $i < count($val); $i++)
                            @php $pageName=$val[$i]['page_name'] @endphp
                            <li>
                                <a href="{{route($pageName)}}" class="side-menu {{ Route::currentRouteName() == $pageName  ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__title">{{$val[$i]['page_title']}}</div>
                                </a>
                            </li>
                            @endfor
                        </ul>
                    </li>
                    @endif
                    @endforeach
                </ul>
                @dd($data);
            </li>
            @endforeach

           <li>
            <a href="javascript:;" class="side-menu">
                <div class="side-menu__icon"><i data-lucide="zap" class="block mx-auto"></i>  </div>
                <div class="side-menu__title">
                    Leads 
                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="">
                <li>
                    <a href="{{route('lead_create')}}" class="side-menu ">
                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                        <div class="side-menu__title">Add Leads</div>
                    </a>
                </li>
                <li>
                    <a href="{{route('lead_index')}}" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                        <div class="side-menu__title">View Leads</div>
                    </a>
                </li>
               
            </ul>
        </li>
            {{-- <li>
                <a href="javascript:;" class="side-menu" onclick="sideBarView('20')">
                    <div class="side-menu__icon">  <i data-lucide="book" class="block mx-auto"></i>  </div>
                    <div class="side-menu__title">
                        Complaint 
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="{{route('complaint_create')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> Add Complaint </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('complaint_index')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> View Complaint </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('complaint_type_create')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> Add Complaint Type</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('complaint_type_index')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> View Complaint Type</div>
                        </a>
                    </li>
                </ul>
            </li>
            
            <li>
                <a href="javascript:;" class="side-menu"  onclick="sideBarView('21')">
                    <div class="side-menu__icon"> <i data-lucide="codesandbox" class="block mx-auto"></i>  </div>
                    <div class="side-menu__title">
                        Administration
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="{{route('user.create')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> Add User </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.index')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> View User </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('group.create')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> Add Group</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('group.index')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> View Group</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('role.create')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> Add Role</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('role.index')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> View Role</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('unit.create')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> Add Unit</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('unit.index')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> View Unit</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('template.create')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> Add Template</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('template.index')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> View Template</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('daily_calendar.index')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">Calendar Manager</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('escalation_group.create')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">Add Escalation Group</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('escalation_group.index')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">View Escalation Group</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('announcement_create')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">Add Announcement</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('announcement_index')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">View Announcement</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="side-menu" onclick="sideBarView('22')">
                    <div class="side-menu__icon"> <i data-lucide="package" class="block mx-auto"></i> </div>
                    <div class="side-menu__title">
                        Products Management 
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="{{route('complaint_category_create')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">Add Complaint Category</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('e_form_category_create')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">Add Eform Category</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('complaint_category_index')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">View Complaint Category</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('e_form_category_index')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">View Eform Category</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('complaint_product_create')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">Add Complaint Product</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('e_form_product_create')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">Add Eform Product</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('complaint_product_index')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">View Complaint Product</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('e_form_product_index')}}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">View Eform Product</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="archive" class="block mx-auto"></i>  </div>
                    <div class="side-menu__title">
                        Reports
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">Session History Logs Report</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">Transaction Logs Report</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">Agent Activity Logs Report</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">Complaints Detailed Report</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">Complaints Escalation Report</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">Complaint By TAT</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">Complaint By Status</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">SMS Detailed Report</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">SMS Interim Report</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">Send Email Report</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">EForm Detailed Report</div>
                        </a>
                    </li>
                </ul>
                <li>
                    <a href="javascript:;" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="search" class="block mx-auto"></i>  </div>
                        <div class="side-menu__title">
                            Search
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="{{route('customer_search')}}" class="side-menu">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title">Customer Search</div>
                            </a>
                        </li>
                       
                    </ul>
                </li>
                
                <li>
                    <a href="javascript:;" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                        <div class="side-menu__title">
                            CRM User Requests
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="#" class="side-menu">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title">CRM Force Logout</div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="side-menu">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title">CRM Account Unlock</div>
                            </a>
                        </li>
                       
                    </ul>
                </li>
            </li>
            <li>
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="archive" class="block mx-auto"></i>  </div>
                    <div class="side-menu__title">
                        Reports
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="menu__sub-open">
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                            <div class="side-menu__title">
                                Complaint
                                <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="#" class="side-menu">
                                    <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                    <div class="side-menu__title">Detailed Report</div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="side-menu">
                                    <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                    <div class="side-menu__title">Escalation Report</div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="side-menu">
                                    <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                    <div class="side-menu__title">TAT</div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="side-menu">
                                    <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                    <div class="side-menu__title">Status</div>
                                </a>
                            </li>
                           
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                            <div class="side-menu__title">
                                Logs
                                <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="#" class="side-menu">
                                    <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                    <div class="side-menu__title">Session History Report
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="side-menu">
                                    <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                    <div class="side-menu__title">Transaction Report</div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="side-menu">
                                    <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                    <div class="side-menu__title">Agent Activity Report</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                            <div class="side-menu__title">
                                SMS
                                <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="#" class="side-menu">
                                    <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                    <div class="side-menu__title">Detailed Report
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="side-menu">
                                    <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                    <div class="side-menu__title">Interim Report</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">Send Email Report</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">EForm Detailed Report</div>
                        </a>
                    </li>
                </ul>
            </li> --}}
            
        </ul>
    </nav>

   
