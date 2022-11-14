@extends('layouts.main')

@section('content')
<style>
    .grid-cols-12 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
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
                        Add Unit
                    </h2>
                </div>
                <form  method="POST" action="{{ route('unit.store') }}" onsubmit="return check()">
                    @csrf
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div >
                                <label for="regular-form-1" class="form-label">Group  <span style="color: red">*</span></label>
                                    <select data-placeholder="Select your favorite actors" id="group_id" name="group_id" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" required>
                                        @for ($i = 0; $i < count($group); $i++)
                                        <option value="{{$group[$i]->id}}" >{{ucwords($group[$i]->group_name)}}</option>
                                        @endfor
                                    </select>
                            </div>
                            <div >
                                <label for="regular-form-1" class="form-label">Region  <span style="color: red">*</span></label>
                                    <select data-placeholder="Select your favorite actors" name="region_id" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" required>
                                        @for ($i = 0; $i < count($region); $i++)
                                        <option value="{{$region[$i]->id}}" >{{ucwords($region[$i]->region_name)}}</option>
                                        @endfor
                                    </select>
                            </div>
                            <div>
                            <label for="regular-form-1" class="form-label">Unit Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" name="unit_name" placeholder="Unit Name" aria-label="default input inline 2" required>
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Branch Code <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" name="branch_code" placeholder="Branch Code" aria-label="default input inline 2" required>
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Address</label>
                            <input type="text" class="form-control col-span-4" name="address" placeholder="Address" aria-label="default input inline 2" required>
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">E-Mail Address <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" name="email" placeholder="E-Mail Address" aria-label="default input inline 2" required>
                        </div>
                        <div class="form-check form-switch sm:mt-0" style="margin-top: 17px;margin-bottom: 10px;">
                            <label for="regular-form-1" class="form-label">IsActive</label>
                            <input id="show-example-3" data-target="#header" name="is_active" checked value="1" class="show-code form-check-input mr-0 ml-3" type="checkbox" >
                        </div>
                        
                        </div>
                        <div class="grid grid-cols-12 gap-2">
                            <div class="mt-3" >
                                <label for="regular-form-1" class="form-label">Escalation Time Period </label>
                                    <select  class="tom-select w-full tomselected" name="escalation_time1" id="escalation_time1"  tabindex="-1" hidden="hidden">
                                        <option value="0" selected="true">Select Time Period</option>
                                        @for($i = 1; $i <= $tatSave; $i++)
                                        <option value="{{$i}}" >{{$i}} Days</option>
                                        @endfor
                                    </select>
                            </div>

                            <div class="mt-3" >
                                <label for="regular-form-1" class="form-label">Level 1</label>
                                    <select  class="tom-select w-full tomselected" name="level1[]" id="level1" multiple="multiple">
                                        @for($i=0; $i < count($escalationGroup); $i++)
                                        <option value="{{$escalationGroup[$i]->id}}" >{{ ucwords($escalationGroup[$i]->group_name) }}</option>
                                        @endfor
                                    </select>
                            </div>
                    </div>
                    <div class="grid grid-cols-12 gap-2">
                        <div class="mt-3" >
                            <label for="regular-form-1" class="form-label">Escalation Time Period </label>
                                <select  class="tom-select w-full tomselected " name="escalation_time2" id="escalation_time2" tabindex="-1" hidden="hidden">
                                    <option value="0" selected="true">Select Time Period</option>
                                        @for($i = 1; $i <= $tatSave; $i++)
                                        <option value="{{$i}}" >{{$i}} Days</option>
                                        @endfor
                                    
                                </select>
                        </div>

                        <div class="mt-3" >
                            <label for="regular-form-1" class="form-label">Level 2</label>
                            <select  class="tom-select w-full tomselected" name="level2[]" id="level2" multiple="multiple">
                                @for($i=0; $i < count($escalationGroup); $i++)
                                <option value="{{$escalationGroup[$i]->id}}" >{{ ucwords($escalationGroup[$i]->group_name) }}</option>
                                @endfor
                            </select>
                        </div>
                </div>
                   
                <div class="grid grid-cols-12 gap-2">
                    <div class="mt-3" >
                        <label for="regular-form-1" class="form-label">Escalation Time Period </label>
                            <select  class="tom-select w-full tomselected " id="escalation_time3" name="escalation_time3" tabindex="-1" hidden="hidden">
                                <option value="0" selected="true">Select Time Period</option>
                                @for($i = 1; $i <= $tatSave; $i++)
                                <option value="{{$i}}" >{{$i}} Days</option>
                                @endfor
                                
                            </select>
                    </div>

                    <div class="mt-3" >
                        <label for="regular-form-1" class="form-label">Level 3</label>
                            <select  class="tom-select w-full tomselected" name="level3[]" id="level3" multiple="multiple">
                                @for($i=0; $i < count($escalationGroup); $i++)
                                <option value="{{$escalationGroup[$i]->id}}" >{{ ucwords($escalationGroup[$i]->group_name) }}</option>
                                @endfor
                            </select>
                    </div>
            </div>
            <div class="grid grid-cols-12 gap-2">
                <div class="mt-3" >
                    <label for="regular-form-1" class="form-label">Escalation Time Period </label>
                        <select  class="tom-select w-full tomselected " name="escalation_time4" id="escalation_time4" tabindex="-1" hidden="hidden">
                            <option value="0" selected="true">Select Time Period</option>
                                @for($i = 1; $i <= $tatSave; $i++)
                                <option value="{{$i}}" >{{$i}} Days</option>
                                @endfor
                            
                        </select>
                </div>

                <div class="mt-3" >
                    <label for="regular-form-1" class="form-label">Level 4</label>
                        <select  class="tom-select w-full tomselected" name="level4[]" id="level4" multiple="multiple">
                            @for($i=0; $i < count($escalationGroup); $i++)
                            <option value="{{$escalationGroup[$i]->id}}" >{{ ucwords($escalationGroup[$i]->group_name) }}</option>
                            @endfor
                        </select>
                </div>
        </div>
                <button type="submit" class="btn btn-primary mt-5">Save</button>
                        
                    </div>
                   
                </div>
                </form>
        </div>
     
     
    </div>
</div>
@push('scripts')
<script>
    function check()
    {
    var time_period1 = $('#escalation_time1').val();
    var level1 = $('#level1').val();
    var time_period2 = $('#escalation_time2').val();
    var level2 = $('#level2').val();
    var time_period3 = $('#escalation_time3').val();
    var level3 = $('#level3').val();
    var time_period4 = $('#escalation_time4').val();
    var level4 = $('#level4').val();

    var arrayTimeCheck = [time_period1,time_period2,time_period3,time_period4];
    var arrayLevelCheck = checkDuplicate([level1,level2,level3,level4]);

    var checkItem = checkDuplicate(arrayTimeCheck);
    var group       = $("#group_id").val();

        if (typeof checkItem == 'undefined' && group == 4) 
        {
            alert("Kindly Select at least two Escalation");
            return false;
        }

        if(checkItem == true)
        {
            alert("Duplicate Escalation Time Period Select");
            return false;
        }
        return true;

    }
 

function checkDuplicate(arrayToCheck){
        var arrayTocheck1 = arrayRemove(arrayToCheck,0);
        arrayTocheck1.sort();
        var last = arrayTocheck1[0];
        for (var i=1; i<arrayTocheck1.length; i++) {
            if (arrayTocheck1[i] == last) { return true; } else { return false; };
            last = arrayTocheck1[i];
        }
    }

    function arrayRemove(arr, value) {

        return arr.filter(function(ele){
            return ele != value;
        });

    }

</script>
@endpush


@endsection
