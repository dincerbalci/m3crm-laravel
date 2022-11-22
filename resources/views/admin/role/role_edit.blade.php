@extends('layouts.main')

@section('content')
<style>
    .grid-cols-12 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
}
</style>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Administration
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <form  method="POST" action="{{ route('role.update',$role->id) }}" onsubmit="return validation()">
                @method("PUT")
                @csrf
            <!-- BEGIN: Input -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Edit Role
                    </h2>
                </div>
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div>
                            <label for="regular-form-1" class="form-label">Primary Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" value="{{$role->primary_name}}" name="primary_name" placeholder="Primary Name" aria-label="default input inline 2" required>
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Secondary Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" value="{{$role->secondary_name}}" name="secondary_name" placeholder="Secondary Name" aria-label="default input inline 2" required>
                        </div>
                        <div >
                            <label for="regular-form-1" class="form-label">E-Mail Address</label>
                            <input type="text" class="form-control col-span-4" value="{{$role->email}}" name="email" placeholder="E-Mail Address" aria-label="default input inline 1">
                            </div>
                            <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Expiry Date </label>
                            <div id="basic-datepicker">
                                <div class="preview">
                                    <input type="text" name="expiry_date" value="{{$role->expiry_date}}" class="datepicker form-control  block mx-auto" data-single-mode="true">
                                </div>
                               
                            </div>
                        </div>
                        <div class="form-check form-switch  sm:mt-0" style="margin-top: 46px;">
                            <label for="regular-form-1" class="form-label">IsActive</label>
                            <input id="show-example-3" data-target="#header" name="isactive" {{$role->isactive == '1' ? 'checked' : ''}} value="1" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                        </div>
                        
                        </div>
                        
                    </div>
                   
                    <button type="submit" class="btn btn-primary mt-5">Update</button>
                </div>
                <input type="hidden" id='table_json' name='table_json' value="" />
                </div>
            </form>
     
     
    </div>
    <div class="intro-y col-span-12 lg:col-span-6">
    <div class="intro-y box mt-5">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
                Permission Assignment
            </h2>
            <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                <label class="form-check-label ml-0" for="show-example-1">Full Permission</label>
                <input id="selectAll" class="show-code form-check-input mr-0 ml-3" type="checkbox">
            </div>
        </div>
        <div id="boxed-accordion" class="p-5">
            <div class="preview">
                <div id="faq-accordion-2" class="accordion accordion-boxed">
                    @php $count=0; @endphp
                    @foreach ($parent as $parents)
                      @php  $parentId = $parents->id @endphp
                    <div class="accordion-item">
                        <div id="faq-accordion-content-5" class="accordion-header">
                            <button class="accordion-button" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-5" aria-expanded="true" aria-controls="faq-accordion-collapse-5">{{ucwords($parents->name)}}</button>
                        </div>
                        <div id="faq-accordion-collapse-{{$count}}" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-5" data-tw-parent="#faq-accordion-2" style="display: block;">
                            <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed"> 
                                <table class="table table-report sm:mt-2 tblPermissions">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap" style="width: 40%;"></th>
                                        <th class="whitespace-nowrap">Create</th>
                                        <th class="whitespace-nowrap">Update</th>
                                        <th class="whitespace-nowrap">Delete</th>
                                        <th class="whitespace-nowrap">View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $modules=App\Models\Role::GetModules($parentId); @endphp
                                    @foreach ($modules as $row)
                                    @php
                                        $create='';
                                        $update='';
                                        $delete='';
                                        $view='';
                                    for($i=0; $i < count($permissions); $i++)
                                    {
                                        
                                        if($row->id == $permissions[$i]->module_id)
                                        {
                                            $create=$permissions[$i]->create == '1' ? 'checked' : '';
                                            $update=$permissions[$i]->update == '1' ? 'checked' : '';
                                            $delete=$permissions[$i]->delete == '1' ? 'checked' : '';
                                            $view  =$permissions[$i]->view == '1' ? 'checked' : '';
                                            break;
                                        }
                                    }
                                    @endphp
                                    <tr class="intro-x">
                                        <td style="display: none;">{{$row->id}}</td>
                                        <td class="text-left">{{ucwords($row->name)}}</td>
                                        <td class="text-left">
                                        <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                                            <input id="show-example-1" name="chkCreate" class="show-code form-check-input mr-0 ml-3 chkCreate" {{$create}}  value="1" type="checkbox">
                                        </div>
                                        </td>
                                        <td class="text-left">
                                        <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                                            <input id="show-example-1" name="chkUpdate" class="show-code form-check-input mr-0 ml-3 chkUpdate" {{$update}} value="1" type="checkbox">
                                        </div></td>
                                        <td class="text-left">
                                        <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                                            <input id="show-example-1" name="chkDelete" class="show-code form-check-input mr-0 ml-3 chkDelete" {{$delete}} value="1" type="checkbox">
                                        </div></td>
                                        <td class="text-left "> 
                                            <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                                                <input id="show-example-1" name="chkView" class="show-code form-check-input mr-0 ml-3 chkView" {{$view}} value="1" type="checkbox">
                                            </div>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table> 
                        </div>
                    </div>
                    </div>
                    @php $count++; @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function validation()
    {
        tableDate=JSON.stringify(storeTblValues());
        $('#table_json').val(tableDate);
    }
    
    function storeTblValues()
    {
        var TableData = new Array();

        $('.tblPermissions tr').each(function(row, tr){

            TableData[row]={
                "moduleid"  : $(tr).find('td:eq(0)').text()
                ,"create"   : $(tr).find('.chkCreate').is(":checked") ? 1 : 0
                ,"update"   : $(tr).find('.chkUpdate').is(":checked") ? 1 : 0
                ,"delete"   : $(tr).find('.chkDelete').is(":checked") ? 1 : 0
                ,"view"     : $(tr).find('.chkView').is(":checked") ? 1 : 0
            }

        });
        TableData.shift();  // first row will be empty - so remove
        return TableData;
    }

   

$('#selectAll').click(function (e) {
    $('.tblPermissions').find('td input:checkbox').prop('checked', this.checked);
});
  </script>
@endpush

@endsection
