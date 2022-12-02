<div class="grid grid-cols-12 gap-6">
    {{--   2xl:col-span-9 --}}
    <div class="col-span-12 ">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        {{$dataSiderBarArr[0]->module}} Lisiting
                    </h2>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    @for($i=0; $i < count($dataSiderBarArr); $i++)
                    <a href="{{route($dataSiderBarArr[$i]->page_name)}}" class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex side-menu__icon">
                                   <?php echo html_entity_decode($dataSiderBarArr[$i]->page_icon) ?>
                                </div>
                                <div class="text-2xl font-medium leading-8 mt-6">{{$dataSiderBarArr[$i]->page_title}}</div>
                            </div>
                        </div>
                    </a>
                    @endfor
                </div>
            </div>
        </div>
    </div>
  
</div>

        
