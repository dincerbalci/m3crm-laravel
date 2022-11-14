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
            E-Form Management
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Edit E-Form Type
                    </h2>
                </div>
                <form  method="POST" action="{{ route('e_form_type.update',$eFormType->id) }}" >
                    @method("PUT")
                    @csrf
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div >
                                <label for="regular-form-1" class="form-label">Product Category  <span style="color: red">*</span></label>
                                    <select name="product_category_id" id='product_category_id' data-placeholder="Select your favorite actors" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" onchange="productA(this.value)">
                                        <option value="0" selected="true">Select Product Category </option>
                                        @for($i=0; $i < count($productCategory); $i++)
                                        <option value="{{$productCategory[$i]->id}}" {{$eFormType->product_category_id == $productCategory[$i]->id ? 'Selected' : ''}}>{{ucwords($productCategory[$i]->fullname)}}</option>
                                        @endfor
                                    </select>
                            </div>
                            <div >
                                <label for="regular-form-1" class="form-label">Product  <span style="color: red">*</span></label>
                                <select  name="product_id"  class="form-select " id="product"  required >
                                    <option value="" selected="true">Select product</option>
                                </select>
                            </div>
                            <div>
                            <label for="regular-form-1" class="form-label">E-Form Type <span style="color: red">*</span></label>
                            <input type="text" name="type" value="{{$eFormType->fullname}}" class="form-control col-span-4" placeholder="E-Form Type" aria-label="default input inline 2">
                            <div class="form-help">Note: Enter values in hours.</div>
                        </div>
                        
                        <div class="form-check form-switch  mt-3 sm:mt-0">
                            <label for="regular-form-1" class="form-label">IsActive</label>
                            <input id="show-example-3" name="is_active" {{$eFormType->isactive == '1' ? "Checked" : '' }} data-target="#header" value="1" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                        </div>
                        {{-- <div class="form-check form-switch  mt-3 sm:mt-0">
                            <label for="regular-form-1" class="form-label">Subcription</label>
                            <input id="show-example-3" name="is_subscription" {{$eFormType->is_subscription == '1' ? "Checked" : '' }} data-target="#header" value="1" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                        </div> --}}
                        {{-- <div class="flex flex-col sm:flex-row mt-2">
                            <label for="regular-form-1" class="form-label" style="margin-right: 14px;">Operation Mode</label>
                            <div class="form-check mr-2">
                                <input id="radio-switch-4" class="form-check-input" type="radio" checked name="operation_mode" value="1" {{$eFormType->operation_mode == '1' ? "Checked" : '' }} onclick="assignee(this.value)">
                                <label class="form-check-label"  for="radio-switch-4">Auto</label>
                            </div>
                            <div class="form-check mr-2 mt-2 sm:mt-0">
                                <input id="radio-switch-5" class="form-check-input" type="radio" name="operation_mode" value="0" {{$eFormType->operation_mode == '0' ? "Checked" : '' }} onclick="assignee(this.value)">
                                <label class="form-check-label"  for="radio-switch-5">Manual</label>
                            </div>
                        </div> --}}
                        {{-- <div class="mt-3" id='aaa' >
                            <label for="regular-form-1" class="form-label">Assignee  </label>
                                <select name="group_id" class="tom-select w-full tomselected "  tabindex="-1" hidden="hidden">
                                    <option value="0" selected="true">Select Assignee </option>
                                    @for($i=0; $i < count($group); $i++)
                                    <option value="{{$group[$i]->id}}" {{$eFormType->group_id == $group[$i]->id ? "selected" : '' }}>{{ucwords($group[$i]->group_name)}}</option>
                                    @endfor
                                </select>
                        </div> --}}
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Turn Around Time <span style="color: red">*</span></label>
                            <input type="text" name="tat" id="tat" class="form-control col-span-4" value="{{$eFormType->tat}}" onkeypress="return validateNumbers(event)" placeholder="Turn Around Time" aria-label="default input inline 2" required>
                            <div class="form-help" id='tat_text'>Turn Around Time Should be greater than 23 hours</div>
                        </div>
                       
                        
                        </div>
                        {{-- @for($j=1; $j <= 5; $j++)
                        <div class="grid grid-cols-12 gap-2" id='clonediv'>
                            <div class="mt-3" >
                                <label for="regular-form-1" class="form-label">Escalation Time Period {{$j}}</label>
                                    <select  class="form-select" name="escalation_time{{$j}}">
                                        @php $escalationTime ='escalation_time'.$j @endphp
                                         @for($i = 0; $i <= 100; $i += 10)
                                        <option value="{{$i}}" {{$eFormTypeEscalation[0]->$escalationTime == $i ? "Selected" : ''}} >{{$i}}%</option>
                                        @endfor
                                    </select>
                            </div>

                            <div class="mt-3" >
                                <label for="crud-form-2-tomselected" class="form-label" id="crud-form-2-ts-label">Level {{$j}}</label>
                                <select data-placeholder="Select your favorite actors" name="level{{$j}}[]" class="tom-select w-full tomselected" id="crud-form-2" multiple="multiple" style="z-index: 999 !important;">
                                    @php $level ='level'.$j;
                                        $level=explode(',',$eFormTypeEscalation[0]->$level);
                                    @endphp
                                    @for($i=0; $i < count($user); $i++)
                                        @for($k=0; $k < count($level); $k++)
                                        @if($level[$k] == $user[$i]->id)
                                            <option value="{{$user[$i]->id}}" selected="true">{{ ucwords($user[$i]->user_name) }}</option>
                                        @else
                                            <option value="{{$user[$i]->id}}" >{{ ucwords($user[$i]->user_name) }}</option>
                                        @endif
                                        @endfor
                                    @endfor

                                </select>
                            </div>
                           
                        </div>
                        @endfor
                    <div id='appenddiv'>
                    </div> --}}
                    <button type="submit" class="btn btn-primary mt-5">Update</button>
                        
                    </div>
                   
                </div>
                </form>
           
        </div>
     
     
    </div>
</div>
@push('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script> --}}
<script>
    $("#tat").keyup(function(){
        if($("#tat").val() < 24)
        {
            $("#tat_text").css("color", "red");
        }
        else
        {
            $("#tat_text").css("color", "");
        }
    });
    assignee(`{{$eFormType->operation_mode}}`)
    productA($('#product_category_id').val());
  function productA(val) {
        let value = {
            product_category_id: val,
        };
        $.ajax({
            type: 'GET',
            url: "{{ route('get_product_category_eform') }}",
            data: value,
            success: function(result) {
                
                document.getElementById('product').innerHTML =
                        '<option value="" selected="true">Select product</option>';
                    for (var i = 0; i < result.length; i++) {
                        var product = document.createElement('option');
                        product.value = result[i].id;
                        product.innerHTML = result[i].fullname;
                        if (result[i].id == "{{ $eFormType->product_id }}") product.defaultSelected =
                        true;
                        document.getElementById('product').appendChild(product);
                    }
               
            }
        });
    }


    function removeDiv(obj)
    {
        obj.parentElement.parentElement.remove()
        i--;
    }
    var i=0;
    function appendDiv(obj)
    {
        if(i== 4)
        {
            alert('Limit is 5');
            return false;
        }
        ids=obj.parentElement.parentElement.id;
        aa=$('#'+ids).clone();
        aa[0].children[2].children[0].remove();
        aa[0].children[2].children[0].style.display='block';
        aa[0].id='';
        aa.appendTo("#appenddiv");
        i++;


    }

   function assignee(val)
    {
        if(val == '1')
        {
            $('#aaa').show();
        }
        if(val == '0')
        {
            $('#aaa').hide();
        }
    }
</script>
@endpush
    


@endsection
