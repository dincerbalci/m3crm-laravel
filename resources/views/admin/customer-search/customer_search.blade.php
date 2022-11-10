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
            Customer Search
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Search
                    </h2>
                </div>
             
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div>
                            <label for="regular-form-1" class="form-label">CNIC <span style="color: red">*</span></label>
                            <input type="text" id='cnic' name="cnic" class="form-control col-span-4" onkeypress="return validateNumbers(event);" placeholder="CNIC" aria-label="default input inline 2" required>
                                <button type="button" class="btn btn-primary mt-5" onclick="cnicFormSubmit()">Search</button>
                                <button onclick="$('#cnic').val('')" class="btn btn-primary mt-5">Clear Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="intro-y col-span-12 lg:col-span-6" id="SearchForm" style="display: none">
            <div class="intro-y col-span-12 lg:col-span-12">
                <!-- BEGIN: Input -->
                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <ul class="nav nav-boxed-tabs" role="tablist">
                            <li id="example-1-tab" class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-1" type="button" role="tab" aria-controls="example-tab-3" aria-selected="true">Basic Information</button>
                            </li>
                            <li id="example-2-tab" class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-2" type="button" role="tab" aria-controls="example-tab-4" aria-selected="false">Other Information</button>
                            </li>
                        </ul>
                    </div>
                    <div id="boxed-tab" class="p-1">
                        <div class="preview">
                            <div class="tab-content">
                                <div id="example-tab-1" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-1-tab" style=""> 
                                    <div class="overflow-x-auto scrollbar-hidden">
                                        <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                                            <table class="table table-report sm:mt-2">
                                                <thead>
                                                    <tr>
                                                        <th class="whitespace-nowrap">CNIC</th>
                                                        <th class="whitespace-nowrap">Full Name</th>
                                                        <th class="whitespace-nowrap">Mother Maiden Name</th>
                                                        <th class="whitespace-nowrap">Mobile #</th>
                                                        <th class="whitespace-nowrap">D.O.B</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="intro-x">
                                                        <td class="text-left">42000-0514652-9</td>
                                                        <td class="text-left">Mr. MUHAMMAD SHOAIB MC</td>
                                                        <td class="text-left">Sanober</td>
                                                        <td class="text-left">03462345016</td>
                                                        <td class="text-left">	1981-01-01</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="example-tab-2" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-2-tab" style=""> 
                                    <div class="overflow-x-auto scrollbar-hidden">
                                        <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                                            <table class="table table-report sm:mt-2">
                                                <thead>
                                                    <tr>
                                                        <th class="whitespace-nowrap">E-Mail</th>
                                                        <th class="whitespace-nowrap">Residential Address</th>
                                                        <th class="whitespace-nowrap">Residential No</th>
                                                        <th class="whitespace-nowrap">Office No</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="intro-x">
                                                        <td class="text-left"></td>
                                                        <td class="text-left">FWBL HO</td>
                                                        <td class="text-left"></td>
                                                        <td class="text-left"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                                            {{ $weekendsCalendar->links('paginate.paginate_ui') }}
                                        </div> --}}
                                       
                                    </div>   
                                </div>
                                <hr>
                                <div  class="" role="tabpanel" > 
                                    <div class="overflow-x-auto scrollbar-hidden">
                                        <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                                            <table class="table table-report sm:mt-2">
                                                <thead>
                                                    <tr>
                                                        <th class="whitespace-nowrap">S.No</th>
                                                        <th class="whitespace-nowrap">Question</th>
                                                        <th class="whitespace-nowrap">Answer</th>
                                                        <th class="whitespace-nowrap">Correct</th>
                                                        <th class="whitespace-nowrap">Incorrect</th>
                                                        <th class="whitespace-nowrap">Not Answered</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table_data">
                                                    <tr class="intro-x">
                                                        <td class="text-left">1</td>
                                                        <td class="text-left">Full Name</td>
                                                        <td class="text-left">Mr.MUHAMMAD SHOAIB MC</td>
                                                        <td class="text-left"><input  id="bordered-radio-1" type="radio" value="" name="bordered-radio" class="checked"></td>
                                                        <td class="text-left"><input  id="bordered-radio-1" type="radio" value="" name="bordered-radio" class=""></td>
                                                        <td class="text-left"><input  id="bordered-radio-1" type="radio" value="" name="bordered-radio" class=""></td>
                                                    </tr>
                                                    <tr class="intro-x">
                                                        <td class="text-left">2</td>
                                                        <td class="text-left">Mother Maiden</td>
                                                        <td class="text-left">Sanober</td>
                                                        <td class="text-left"><input  id="bordered-radio-2" type="radio" value="" name="bordered-radio2" class="checked"></td>
                                                        <td class="text-left"><input  id="bordered-radio-2" type="radio" value="" name="bordered-radio2" class=""></td>
                                                        <td class="text-left"><input  id="bordered-radio-2" type="radio" value="" name="bordered-radio2" class=""></td>
                                                    </tr>
                                                    <tr class="intro-x">
                                                        <td class="text-left">3</td>
                                                        <td class="text-left">Mobile Number</td>
                                                        <td class="text-left">03462345016 </td>
                                                        <td class="text-left"><input  id="bordered-radio-3" type="radio" value="" name="bordered-radio3" class="checked"></td>
                                                        <td class="text-left"><input  id="bordered-radio-3" type="radio" value="" name="bordered-radio3" class=""></td>
                                                        <td class="text-left"><input  id="bordered-radio-3" type="radio" value="" name="bordered-radio3" class=""></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>   
                                </div>
                                <button style="margin: 13px;" id="btnValidate2" class="btn btn-primary mt-5">Validate</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   

@push('scripts')
<script>
    function cnicFormSubmit()
    {
        cnic=$('#cnic').val();
        if(cnic.length == '15')
        {
            $("#SearchForm").show();
        }
    }
    $(document).on('click','#btnValidate2', function() {
        check = true;
        allChecked=document.querySelectorAll('.checked');
        for (let i = 0; i < allChecked.length; i++) {
             element = allChecked[i].checked;
             if(element == false)
             {
                check = false;
                alert('Please select all correct answer in each question.');
                break;
             }
        }
			if(check){
                window.location.href="{{route('customer_info')}}";
			}
			
		});
    
 
  
</script>
@endpush
    


@endsection
