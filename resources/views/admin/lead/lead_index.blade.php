@extends('layouts.main')

@section('content')
<style>
    .grid-cols-12 {
    grid-template-columns: repeat(4, minmax(0, 1fr));
}
</style>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Leads Management
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Lead Search
                    </h2>
                </div>
                <form id='complaint_form_search' method="GET" action="" >
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div>
                            <label for="regular-form-1" class="form-label">CNIC</label>
                            <input type="text" class="form-control col-span-4" id='cnic' value="{{request()->cnic}}" name="cnic" placeholder="CNIC" aria-label="default input inline 2">
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Lead ID</label>
                            <input type="text" class="form-control col-span-4" value="{{request()->complaint_number}}" placeholder="Lead ID" name="complaint_number" aria-label="default input inline 2">
                        </div>
                        <div >
                            <label for="regular-form-1" class="form-label">Product</label>
                                <select data-placeholder="Select your favorite actors"  name='Product' class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="">Select Product </option>
                                    <option value="">Conventional</option>
                                    <option value="">Takaful</option>
                                    <option value="">Vitality</option>
                                    <option value="">Personal Accident</option>
                                    <option value="">Corporate Solution GMD</option>
                                </select>
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Call Back Phone</label>
                            <input type="text" class="form-control col-span-4 number" value="{{request()->call_back_phone}}" name="call_back_phone" name="call_back_number" placeholder="92-xxxxxxxxxxx" aria-label="default input inline 2">
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Lead Status</label>
                                <select data-placeholder="Select your favorite actors" name="complaint_status"  class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="" >Select Lead Status</option>
                                    <option value="">Initiated</option>
                                    <option value="">In Progress</option>
                                    <option value="">Follow-up</option>
                                    <option value="">Bought</option>
                                    <option value="">Not Interested</option>
                                    <option value="">General Inquiry</option>
                                </select>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">City</label>
                                <select data-placeholder="Select your favorite actors" name="product"  class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden">
                                    <option value="" >Select City</option>
                                    <option value="">Central</option>
                                    <option value="">North</option>
                                    <option value="">South</option>
                                </select>
                        </div>
                            <div class="mt-3">
                            <label for="regular-form-1" class="form-label">From Date</label>
                            <div id="basic-datepicker">
                                <div class="preview">
                                    <input type="text" name="from_date"  value="" class="datepicker form-control  block mx-auto" data-single-mode="true">
                                </div>
                               
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">To Date</label>
                            <div id="basic-datepicker">
                                <div class="preview">
                                    <input type="text" name="to_date"  value="" class="datepicker form-control  block mx-auto" data-single-mode="true">
                                </div>
                               
                            </div>
                        </div>
                        
                        </div>
                        
                    </div>
                   
                    <button type="submit" class="btn btn-primary mt-5">Search</button>
                    <button type="button" class="btn btn-inverse mt-5" onclick='document.getElementById("complaint_form_search").reset()'>Reset</button>
                    <button type="submit" class="btn btn-success mt-5">Export</button>
                </div>
            </form>

           
        </div>
     
     
    </div>
</div>
 
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="intro-y flex items-center ">
            <h2 class="text-lg font-medium mr-auto">
                Leads Data
            </h2>
        </div>
        <div class="overflow-x-auto scrollbar-hidden">
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">Leads Id</th>
                            <th class="whitespace-nowrap">Leads Status</th>
                            <th class="whitespace-nowrap">Leads Name</th>
                            <th class="whitespace-nowrap">Intersted Product</th>
                            <th class="whitespace-nowrap">Call back</th>
                            <th class="whitespace-nowrap">Call Time</th>
                            <th class="whitespace-nowrap">City</th>
                            <th class="whitespace-nowrap">Area</th>
                            <th class="whitespace-nowrap">Assigned By</th>
                            <th class="whitespace-nowrap">Assigned To</th>
                            <th class="whitespace-nowrap">Created Date/Time</th>
                            <th class="whitespace-nowrap">Exceed Date/Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr class="intro-x">
                            <td class="text-left">LM190219002</td>
                            <td class="text-left"><span class='bg-warning/20 text-warning rounded px-2 mr-5'>Follow-up</span></td>
                            <td class="text-left">mariyum zahid</td>
                            <td class="text-left">Vitality</td>
                            <td class="text-left">03000432997</td>
                            <td class="text-left">2019-02-20 10:45:00</td>
                            <td class="text-left">South</td>
                            <td class="text-left"></td>
                            <td class="text-left">Sana Shafiq</td>
                            <td class="text-left">Moin Khan</td>
                            <td class="text-left">2019-02-19 10:48:58</td>
                            <td class="text-left">2019-03-21 00:00:00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
            </div>
        </div>
    </div>
    <!-- END: HTML Table Data -->
    @push('scripts')
<script>
    var date = $('#from_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
    console.log(date);

</script>
@endpush
@endsection
