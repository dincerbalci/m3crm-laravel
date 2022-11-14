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
    <form  method="POST" action="{{ route('user.store') }}" onsubmit="return validation()">
        @csrf
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Add User
                    </h2>
                </div>
               
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div>
                            <label for="regular-form-1" class="form-label">First Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" value="{{ old('first_name') }}" name="first_name" placeholder="First Name" aria-label="default input inline 2" required>
                            @error('first_name')
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Last Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" value="{{ old('last_name') }}" name="last_name" placeholder="Last Name" aria-label="default input inline 2" required>
                            @error('first_name')
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div >
                            <label for="regular-form-1" class="form-label">Group <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" name="group_id" id="ddlGroups" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" required>
                                <option value="0" selected="true">Select Group </option>
                                @for ($i = 0; $i < count($group); $i++) 
                                <option value="{{$group[$i]->id}}" {{request()->group_id == $group[$i]->id ? 'Selected' : ''}}>{{ucwords($group[$i]->group_name)}}</option>
                                @endfor
                            </select>
                               
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">User Id <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" value="{{ old('user_name') }}" name="user_name" placeholder="User Id" aria-label="default input inline 1">
                            @error('user_name')
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">E-Mail <span style="color: red">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control col-span-4" placeholder="E-Mail" aria-label="default input inline 1">
                            @error('email')
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Password <span style="color: red">*</span></label>
                            <input type="password" id="password" name="password" class="form-control col-span-4" placeholder="Password" aria-label="default input inline 1" required>
                            @error('password')
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Confirm Password <span style="color: red">*</span></label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control col-span-4" placeholder="Confirm Password" aria-label="default input inline 1" required>
                            @error('confirm_password')
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                            
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Employee Id <span style="color: red">*</span></label>
                            <input type="text" name="employee_id" value="{{ old('employee_id') }}" class="form-control col-span-4" placeholder="Employee Id" aria-label="default input inline 1" onkeypress="return validateNumbers(event)" required>
                            @error('employee_id')
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Mobile Number <span style="color: red">*</span></label>
                            <input type="text" name="mobile_no" value="{{ old('mobile_no') }}" class="form-control col-span-4 number" placeholder="92-xxxxxxxx" aria-label="default input inline 1" required>
                            @error('mobile_no')
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Region <span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" name="region_id" class="form-select" id="ddlRegion" required>
                                <option value="" selected="true">Select Region </option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Branch<span style="color: red">*</span></label>
                            <select data-placeholder="Select your favorite actors" name="unit_id" class="form-select" id="ddlUnit" required>
                                <option value="" selected="true">Select Branch</option>
                            </select>
                        </div>
                      
                        <div class="form-check form-switch  sm:mt-0" style="margin-top: 13px;">
                            <label for="regular-form-1" class="form-label">Is Active</label>
                            <input id="show-example-3" data-target="#header" name="isactive" checked value="1" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                        </div>
                        <div class="form-check form-switch  sm:mt-0" style="margin-top: 13px;">
                            <label for="regular-form-1" class="form-label">Is Admin</label>
                            <input id="show-example-3" data-target="#header" name="isadmin" value="1" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                        </div>
                        <div class="form-check form-switch  sm:mt-0" style="margin-top: 13px;">
                            <label for="regular-form-1" class="form-label">All Complaints</label>
                            <input id="show-example-3" data-target="#header" name="is_all_complaint" value="1" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                        </div>
                        <div class="form-check form-switch  sm:mt-0" style="margin-top: 13px;">
                            <label for="regular-form-1" class="form-label">All EForms</label>
                            <input id="show-example-3" data-target="#header" name="is_all_eform" value="1" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                        </div>
                        
                        </div>
                        
                    </div>
                   
                </div>
           
        </div>
     
     
    </div>
 
</div>
<div class="intro-y col-span-12 lg:col-span-6" style="margin-bottom: 200px; margin-top: 20px;">
    <!-- BEGIN: Input -->
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
                Role Assignment
            </h2>
        </div>
        <div id="inline-form" class="p-5">
            <div class="preview">
                <div class="grid grid-cols-12 gap-2">
                    <div class="mt-3">
                        <label for="crud-form-2-tomselected" class="form-label" id="crud-form-2-ts-label">Select Role</label>
                        <select data-placeholder="Select your favorite actors" name="role_id" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                            @for ($i = 0; $i < count($role); $i++) 
                            <option value="{{$role[$i]->id}}" >{{ucwords($role[$i]->primary_name)}}</option>
                            @endfor
                        </select>
                    </div>
                       
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary mt-5">Save</button>

            </div>
        </div>
   
</div>
</form>

</div>
@push('scripts')
<script>
    function validation()
    {
        console.log('aa');
        if($('#confirm_password').val() != $('#password').val())
        {
            alert("Password do not match with comfirm password");
            return false;
        }
        return true;

    }

  $(document).on('change','#ddlGroups', function (){
    //$('#ddlUsers').empty();
    var group = $(this).val();
    url = "{{ route('get_unit_groups') }}";
    if(group == 4){
        $('#ddlUnit').html('');
        $("#ddlRegion").attr('disabled',false);
        GetAllRegions();
    }else{
        $("#ddlRegion").html('');
        $("#ddlRegion").attr('disabled',true);
    }

    $.ajax({
        type: "GET",
        url: url,
        data:{
            group  : group
        }
    }).done(function (data) {

        if(group == 4){
            $('#ddlUnit').html('');
        }else{
            $('#ddlUnit').html(data);
        }

    });
});
function GetAllRegions(){
    url = "{{ route('get_all_regions') }}";
    $.ajax({
        type: "Get",
        url: url,
        
    }).done(function (data) {
        $('#ddlRegion').html(data);
    });

}
$(document).on('change','#ddlRegion', function (){
    
    url = "{{ route('get_unit_regions') }}";
    var region = $(this).val();

    $.ajax({
        type: "GET",
        url: url,
        data:{
            region_id  : region
        }
    }).done(function (data) {
        //console.log(data);
        $('#ddlUnit').html(data);
    });

});

  </script>
@endpush


@endsection
