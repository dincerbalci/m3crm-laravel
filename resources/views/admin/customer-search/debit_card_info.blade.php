    <div class="intro-y col-span-12 lg:col-span-6" id="SearchForm" >
        <div class="intro-y col-span-12 lg:col-span-12">
            <!-- BEGIN: Input -->
            <div class="intro-y box ">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <ul class="nav nav-boxed-tabs" role="tablist">
                        <li id="example-5-tab" class="nav-item flex-1" role="presentation">
                            <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-5" type="button" role="tab" aria-controls="example-tab-5" aria-selected="true">ATM/Debit Card Details</button>
                        </li>
                        <li id="example-6-tab" class="nav-item flex-1" role="presentation">
                            <button class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-6" type="button" role="tab" aria-controls="example-tab-6" aria-selected="false">Activation/DeActivation</button>
                        </li>
                        <li id="example-7-tab" class="nav-item flex-1" role="presentation">
                            <button class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-7" type="button" role="tab" aria-controls="example-tab-7" aria-selected="false">Debit Card Status Change</button>
                        </li>
                    </ul>
                </div>
                <div id="boxed-tab" class="p-1">
                    <div class="preview">
                        <div class="tab-content">
                            <div id="example-tab-5" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-1-tab" style=""> 
                                <div class="overflow-x-auto scrollbar-hidden">
                                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                                        <div class="intro-y col-span-12 lg:col-span-6">
                                            <div id="inline-form" class="p-5">
                                                <div class="preview">
                                                    <div class="grid grid-cols-12 gap-2">
                                                        <div >
                                                            <label for="regular-form-1" class="form-label">Card Num</label>
                                                            <input type="text"  class="form-control col-span-4 " value="11111-1111111-1" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                        </div>
                                                        <div >
                                                            <label for="regular-form-1" class="form-label">Embossed Name</label>
                                                            <input type="text"  class="form-control col-span-4 " value="MUHAMMAD NOUMAN" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                        </div>
                                                        <div >
                                                            <label for="regular-form-1" class="form-label">Withdrawal Limit</label>
                                                            <input type="text"  class="form-control col-span-4 " value="{{ number_format('40000')}}" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="regular-form-1" class="form-label">Purchase Limit</label>
                                                            <input type="text"  class="form-control col-span-4 " value="{{number_format('90000')}}" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="regular-form-1" class="form-label">Fund Transfer Limit</label>
                                                            <input type="text"  class="form-control col-span-4 " value="{{number_format('100000')}}" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="regular-form-1" class="form-label">Maximum Pin retries</label>
                                                            <input type="text"  class="form-control col-span-4 " value="3" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="regular-form-1" class="form-label">Pin retries remaining</label>
                                                            <input type="text"  class="form-control col-span-4 " value="3" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="regular-form-1" class="form-label">Pin expiry date</label>
                                                            <input type="text"  class="form-control col-span-4 " value="2022-10-10" name="customer_mobile" placeholder="92-xxxxxxxxxx"  aria-label="default input inline 1" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="example-tab-6" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-2-tab" style=""> 
                                <div class="overflow-x-auto scrollbar-hidden">
                                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                                        <div class="intro-y col-span-12 lg:col-span-6">
                                            <div id="inline-form" class="p-5">
                                                <div class="preview">
                                                    <div class="grid grid-cols-12 gap-2">
                                                        <div >
                                                            <label for="regular-form-1" class="form-label">Transaction Type</label>
                                                            <select data-placeholder="Select your favorite actors" name='product_category_id' class="form-select " >
                                                                <option value="0" selected="true">Select Transaction Type</option>
                                                                <option value="1" >E-Commerce</option>
                                                                <option value="2" >International Transaction</option>
                                                            </select>
                                                        </div>
                                                        <div >
                                                            <label for="regular-form-1" class="form-label">Change Status</label>
                                                            <select data-placeholder="Select your favorite actors" name='product_category_id' class="form-select " >
                                                                <option value="1" >Activate</option>
                                                                <option value="2" >De-Activate</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="regular-form-1" class="form-label">From Date</label>
                                                            <div class="preview">
                                                                <input type="date" name="date_of_birth" class=" form-control  block mx-auto" data-single-mode="true">
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="regular-form-1" class="form-label">To Date</label>
                                                            <div class="preview">
                                                                <input type="date" name="date_of_birth" class=" form-control  block mx-auto" data-single-mode="true">
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="regular-form-1" class="form-label">Amount</label>
                                                            <input type="text"  class="form-control col-span-4 " onkeypress="return validateNumbers(event);"  value="" name="customer_mobile" placeholder="00.00"  aria-label="default input inline 1" >
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="regular-form-1" class="form-label">Amount Remaining</label>
                                                            <input type="text"  class="form-control col-span-4 " onkeypress="return validateNumbers(event);" value="" name="customer_mobile" placeholder="00.00"  aria-label="default input inline 1" disabled>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="regular-form-1" class="form-label">Caution</label>
                                                            <textarea id="validation-form-6" class="form-control" onkeyup="validateAlphabetsAndNUumber(event)" maxlength='255' name="description" placeholder="Description" minlength="10" required></textarea>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-primary mt-5">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="example-tab-7" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-3-tab" style=""> 
                                <div class="overflow-x-auto scrollbar-hidden">
                                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                                        <div class="intro-y col-span-12 lg:col-span-6">
                                            <div id="inline-form" class="p-5">
                                                <div class="preview">
                                                    <div class="grid grid-cols-12 gap-2">
                                                        <div >
                                                            <label for="regular-form-1" class="form-label">CNIC</label>
                                                            <input type="text"  class="form-control col-span-4 "   value="42000-0514652-9" name="customer_mobile" placeholder="00.00"  aria-label="default input inline 1" disabled>
                                                        </div>
                                                        <div >
                                                            <label for="regular-form-1" class="form-label">Status</label>
                                                            <select data-placeholder="Select your favorite actors" name='product_category_id' class="form-select " >
                                                                <option value="1" >Active</option>
                                                                <option value="2" >In-Active</option>
                                                                <option value="3" >Block</option>
                                                            </select>
                                                        </div>
                                                        <div >
                                                            <label for="regular-form-1" class="form-label">Caution</label>
                                                            <textarea id="validation-form-6" class="form-control" onkeyup="validateAlphabetsAndNUumber(event)" maxlength='255' name="description" placeholder="Description" minlength="10" required></textarea>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-primary mt-5">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>