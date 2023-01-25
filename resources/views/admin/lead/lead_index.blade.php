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
                <div
                    class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Lead Search
                    </h2>
                </div>
                <form id='complaint_form_search' method="GET" action="">
                    <div id="inline-form" class="p-5">
                        <div class="preview">
                            <div class="grid grid-cols-12 gap-2">
                                <div>
                                    <label for="regular-form-1" class="form-label">CNIC</label>
                                    <input type="text" class="form-control col-span-4" id='cnic'
                                        value="{{ request()->cnic }}" name="cnic" placeholder="CNIC"
                                        aria-label="default input inline 2">
                                </div>
                                {{-- <div>
                            <label for="regular-form-1" class="form-label">Lead ID</label>
                            <input type="text" class="form-control col-span-4" value="{{request()->complaint_number}}" placeholder="Lead ID" name="complaint_number" aria-label="default input inline 2">
                        </div> --}}
                                <div>
                                    <label for="regular-form-1" class="form-label">Lead Category</label>
                                    <select data-placeholder="Select your favorite actors" name='lead_category'
                                        class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1"
                                        hidden="hidden">
                                        <option value="0" selected="true">Select Lead Category</option>
                                        @for ($i = 0; $i < count($category); $i++)
                                            <option value="{{ $category[$i]->id }}"
                                                {{ request()->lead_category == $category[$i]->id ? 'Selected' : '' }}>
                                                {{ $category[$i]->category }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                @if ($userType == '1')
                                    <div>
                                        <label for="regular-form-1" class="form-label">Assigned to</label>
                                        <select data-placeholder="Select your favorite actors" name='assigned_to'
                                            class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1"
                                            hidden="hidden" required>
                                            <option value="0" selected="true">Select Assigned to</option>
                                            @for ($i = 0; $i < count($user); $i++)
                                                <option value="{{ $user[$i]->id }}"
                                                    {{ request()->assigned_to == $user[$i]->id ? 'Selected' : '' }}>
                                                    {{ $user[$i]->first_name }}
                                                    {{ $user[$i]->last_name }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                @endif
                                <div>
                                    <label for="regular-form-1" class="form-label">Lead Status</label>
                                    <select data-placeholder="Select your favorite actors" name="status"
                                        class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1"
                                        hidden="hidden">
                                        <option value="0" selected="true">Select Status</option>
                                        <option value="initiated" {{ request()->status == 'initiated' ? 'Selected' : '' }}>
                                            Initiated</option>
                                        <option value="in process"
                                            {{ request()->status == 'in process' ? 'Selected' : '' }}>In Process</option>
                                        <option value="follow up" {{ request()->status == 'follow up' ? 'Selected' : '' }}>
                                            Follow-up</option>
                                        <option value="bought" {{ request()->status == 'bought' ? 'Selected' : '' }}>Bought
                                        </option>
                                        <option value="not interested"
                                            {{ request()->status == 'not interested' ? 'Selected' : '' }}>Not Interested
                                        </option>
                                        <option value="general inquiry"
                                            {{ request()->status == 'general inquiry' ? 'Selected' : '' }}>General Inquiry
                                        </option>
                                        <option value="convert to customer"
                                            {{ request()->status == 'convert to customer' ? 'Selected' : '' }}>Convert To
                                            Customer
                                        </option>
                                    </select>
                                </div>
                                {{-- <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">City</label>
                                    <select data-placeholder="Select your favorite actors" name="product"
                                        class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1"
                                        hidden="hidden">
                                        <option value="">Select City</option>
                                        <option value="">Central</option>
                                        <option value="">North</option>
                                        <option value="">South</option>
                                    </select>
                                </div> --}}
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-5">Search</button>
                        <button type="button" class="btn btn-inverse mt-5"
                            onclick='document.getElementById("leadss.index").reset()'>Reset</button>
                        {{-- <button type="submit" class="btn btn-success mt-5">Export</button> --}}
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
                            <th class="whitespace-nowrap">Leads Name</th>
                            <th class="whitespace-nowrap">Leads Source</th>
                            <th class="whitespace-nowrap">CNIC</th>
                            <th class="whitespace-nowrap">Email</th>
                            <th class="whitespace-nowrap">Next Follow-up</th>
                            <th class="whitespace-nowrap">Gender</th>
                            <th class="whitespace-nowrap">Leads Value</th>
                            <th class="whitespace-nowrap">Leads Status</th>
                            <th class="whitespace-nowrap">Assigned By</th>
                            @if ($userType == '1')
                                <th class="whitespace-nowrap">Assigned To</th>
                            @endif
                            <th class="whitespace-nowrap">Created Date/Time</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < count($lead); $i++)
                            <tr class="intro-x">
                                <td class="text-left"><a class="colorchange"
                                        href="{{ route('lead.show', $lead[$i]->id) }}">{{ ucwords($lead[$i]->lead_name) }}</a>
                                </td>
                                <td class="text-left"><a class="colorchange"
                                        href="{{ route('lead.show', $lead[$i]->id) }}">{{ ucwords($lead[$i]->lead_source) }}</a>
                                </td>
                                <td class="text-left"><a class="colorchange"
                                        href="{{ route('lead.show', $lead[$i]->id) }}">{{ $lead[$i]->cnic }}</a></td>
                                <td class="text-left">{{ $lead[$i]->email }}</td>
                                <td class="text-left">
                                    {{ isset($lead[$i]->next_follow_up) ? DATE('Y-m-d h:i:s A', strtotime($lead[$i]->next_follow_up)) : '-----------------------' }}
                                </td>
                                <td class="text-left">{{ ucwords($lead[$i]->gender) }}</td>
                                <td class="text-left">{{ $lead[$i]->lead_value }}</td>
                                <td class="text-left"><span
                                        class='bg-warning/20 text-warning rounded px-2 mr-5'>{{ ucwords($lead[$i]->status) }}</span>
                                </td>
                                <td class="text-left">{{ ucwords($lead[$i]->cb_first_name) }}
                                    {{ ucwords($lead[$i]->cb_last_name) }}</td>
                                @if ($userType == '1')
                                    <td class="text-left">{{ ucwords($lead[$i]->at_first_name) }}
                                        {{ ucwords($lead[$i]->at_last_name) }}</td>
                                @endif
                                <td class="text-left">{{ date('Y-m-d', strtotime($lead[$i]->created_at)) }}</td>
                                <td class="text-left">
                                    <div class="flex justify-center items-center">
                                        <a class="flex items-center mr-3" href="{{ route('lead.edit', $lead[$i]->id) }}">
                                            <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                        <a class="flex items-center text-danger" href="javascript:;"
                                            onclick="deleteLead('{{ $lead[$i]->id }}')"> <i data-lucide="trash-2"
                                                class="w-4 h-4 mr-1"></i> Delete </a>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                {{ $lead->links('paginate.paginate_ui') }}
            </div>
        </div>
    </div>
    <!-- END: HTML Table Data -->
    @push('scripts')
        <script>
            var date = $('#from_date').datepicker({
                dateFormat: 'dd-mm-yy'
            }).val();
            // console.log(date);

            function deleteLead(id) {
                value = {
                    id: id
                };
                jQuery.ajax({
                    type: 'GET',
                    url: "{{ route('lead_delete') }}",
                    data: value,
                    success: function(result) {
                        $('#myModalLgHeading').html('Delete Lead');
                        $('#modalBodyLarge').html(result);
                        tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview")).show();
                    }
                });
            }
        </script>
    @endpush
@endsection
