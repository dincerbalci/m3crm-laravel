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
            Services
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6" id="SearchForm" >
            <div class="intro-y col-span-12 lg:col-span-12">
                <!-- BEGIN: Input -->
                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <ul class="nav nav-boxed-tabs" role="tablist">
                            <li id="example-1-tab" class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-1" type="button" role="tab" aria-controls="example-tab-3" aria-selected="true">Customer Info</button>
                            </li>
                            <li id="example-2-tab" class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-2" type="button" role="tab" aria-controls="example-tab-4" aria-selected="false">Account</button>
                            </li>
                            <li id="example-3-tab" class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-3" type="button" role="tab" aria-controls="example-tab-3" aria-selected="false">ATM/Debit Cards</button>
                            </li>
                        </ul>
                    </div>
                    <div id="boxed-tab" class="p-1">
                        <div class="preview">
                            <div class="tab-content">
                                <div id="example-tab-1" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-1-tab" style=""> 
                                    <div class="overflow-x-auto scrollbar-hidden">
                                        <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                                            <div class="intro-y col-span-12 lg:col-span-6">
                                                <!-- BEGIN: Input -->
                                                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                                                        <h2 class="font-medium text-base mr-auto">
                                                            Basic Info
                                                        </h2>
                                                    </div>
                                                    <div id="inline-form" class="p-5">
                                                        <div class="preview">
                                                            <div class="grid grid-cols-12 gap-2">
                                                                <div >
                                                                    <label for="regular-form-1" class="form-label">Title</label>
                                                                    <input type="text"  class="form-control col-span-4 " value="Mr." name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                                </div>
                                                                <div >
                                                                    <label for="regular-form-1" class="form-label">Full Name</label>
                                                                    <input type="text"  class="form-control col-span-4 " value="MUHAMMAD SHOAIB MC" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                                </div>
                                                                <div >
                                                                    <label for="regular-form-1" class="form-label">CNIC</label>
                                                                    <input type="text"  class="form-control col-span-4 " value="42000-0514652-9" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                                </div>
                                                                <div class="mt-3">
                                                                    <label for="regular-form-1" class="form-label">Date Of Birth</label>
                                                                    <input type="text"  class="form-control col-span-4 " value="1981-01-01" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                                </div>
                                                                <div class="mt-3">
                                                                    <label for="regular-form-1" class="form-label">Mother Name</label>
                                                                    <input type="text"  class="form-control col-span-4 " value="Sanober" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                                </div>
                                                                <div class="mt-3">
                                                                    <label for="regular-form-1" class="form-label">IB Status</label>
                                                                    <input type="text"  class="form-control col-span-4 " value="OK" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                                                        <h2 class="font-medium text-base mr-auto">
                                                            Contact
                                                        </h2>
                                                    </div>
                                                    <div id="inline-form" class="p-5">
                                                        <div class="preview">
                                                            <div class="grid grid-cols-12 gap-2">
                                                                <div >
                                                                    <label for="regular-form-1" class="form-label">Residence Phone</label>
                                                                    <input type="text"  class="form-control col-span-4 " value="92" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                                </div>
                                                                <div >
                                                                    <label for="regular-form-1" class="form-label">Residence Address</label>
                                                                    <input type="text"  class="form-control col-span-4 " value="FWBL HO" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                                </div>
                                                                <div >
                                                                    <label for="regular-form-1" class="form-label">Residence Postal Code</label>
                                                                    <input type="text"  class="form-control col-span-4 " value="" name="customer_mobile" placeholder="Post code"  aria-label="default input inline 1" disabled>
                                                                </div>
                                                                <div class="mt-3">
                                                                    <label for="regular-form-1" class="form-label">Mobile Number</label>
                                                                    <input type="text"  class="form-control col-span-4 " value="03462345016" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                                </div>
                                                                <div class="mt-3">
                                                                    <label for="regular-form-1" class="form-label">E-Mail</label>
                                                                    <input type="text"  class="form-control col-span-4 " value="example@gmail.com" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="example-tab-2" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-2-tab" style=""> 
                                    <div class="overflow-x-auto scrollbar-hidden">
                                        <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                                            <table class="table table-report sm:mt-2">
                                                <thead>
                                                    <tr>
                                                        <th class="whitespace-nowrap">Account Number</th>
                                                        <th class="whitespace-nowrap">Account Title</th>
                                                        <th class="whitespace-nowrap">Account Type</th>
                                                        <th class="whitespace-nowrap">Branch Code</th>
                                                        <th class="whitespace-nowrap">Branch Name</th>
                                                        <th class="whitespace-nowrap">Status</th>
                                                        <th class="whitespace-nowrap">Currency</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table_data">
                                                    <tr class="intro-x">
                                                        <td class="text-left">421017013239</td>
                                                        <td class="text-left">Full Name</td>
                                                        <td class="text-left"></td>
                                                        <td class="text-left"></td>
                                                        <td class="text-left"></td>
                                                        <td class="text-left">OK</td>
                                                        <td class="text-left">RKR</td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>   
                                </div>
                                <div id="example-tab-3" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-3-tab" style=""> 
                                    <div class="overflow-x-auto scrollbar-hidden">
                                        <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                                            <table class="table table-report sm:mt-2">
                                                <thead>
                                                    <tr>
                                                        <th class="whitespace-nowrap">Card Num</th>
                                                        <th class="whitespace-nowrap">Card Type</th>
                                                        <th class="whitespace-nowrap">Embossed</th>
                                                        <th class="whitespace-nowrap">Expiry Date</th>
                                                        <th class="whitespace-nowrap">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table_data">
                                                    <tr class="intro-x">
                                                        <td class="text-left">2205550001000003</td>
                                                        <td class="text-left">Paypak Card</td>
                                                        <td class="text-left">MUHAMMAD NOUMAN</td>
                                                        <td class="text-left">09-Nov-2022</td>
                                                        <td class="text-left">	Active</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   

@push('scripts')
<script>
  
</script>
@endpush
    


@endsection
